<?php

# https://raw.github.com/paypal/merchant-sdk-php/master/samples/ExpressCheckout/DGsetExpressCheckout.php
function script_url()
{
	# $protocol = 'http';
	# $domain = $_SERVER['SERVER_NAME'];
	# $port = $_SERVER['SERVER_PORT'];
	# $uri = $_SERVER['REQUEST_URI'];
	# http://home/debug/index.php?asdfsaf&asf=aa
	#	script_url: http://home/debug/index.php?asdfsaf&asf=aa
	#
	# http://home/debug/index.php?asdfsaf&asf=aa
	#	script_url: http://home/debug/index.php

	$protocol = 'http';
	$server_name = $_SERVER['SERVER_NAME'];
	$server_port = $_SERVER['SERVER_PORT'];
	$script_name = $_SERVER['SCRIPT_NAME'];

	if ($server_port == 80) {
		return "$protocol://$server_name$script_name";
	}

	return "$protocol://$server_name:$server_port$script_name";
}

# list($first, $last, $middle) = parse('Janet Cruz');
# list($first, $last, $middle) = parse('Janet J. Cruz');
function parse_name($name)
{
	# guessing
	$part = explode(' ', $name);
	switch (count($part)) {
	case 1:
		$ret = array();
		$ret['first'] = null;
		$ret['last'] = $part[0];
		$ret['middle'] = null;
		break;
	case 2:
		$ret = array();
		$ret['first'] = $part[0];
		$ret['last'] = $part[1];
		$ret['middle']= null;
		break;
	default:
		$ret = array();
		$ret['first'] = $part[0];
		$ret['last'] = $part[count($part)-1];
		$ret['middle'] = implode(' ', array_slice($part, 1, -1));
		break;
	}
	$ret[0] = $ret['first'];
	$ret[1] = $ret['last'];
	$ret[2] = $ret['middle'];
	return $ret;
}

function validate_ipn($ipn, $config)
{
	$param = array_merge(array('cmd' => '_notify-validate'), $ipn);

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $config['www_endpoint']);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($param));
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($curl);
	$errno = curl_errno($curl);
	$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	curl_close($curl);

	if ($errno != 0) {
		return 'ECURL';
	}
	if ($code != 200) {
		return 'EREMOTE';
	}
	if ($response != 'VERIFIED') {
		return $response;
	}

	return null;
}

# PayPal Payments Standard
#
# HTML Variables for PayPal Payments Standard
# https://developer.paypal.com/webapps/developer/docs/classic/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables

function paypal_standard_pdt_get($tx, $config)
{
	$param = array();
	$param['cmd'] = '_notify-synch';
	$param['tx'] = $tx;
	$param['at'] = $config['pdt_token'];

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $config['www_endpoint']);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($param));
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($curl);
	$errno = curl_errno($curl);
	$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	curl_close($curl);

	if ($errno != 0) {
		$param = null;
		$error = 'ECURL';
		return array($param, $error);
	}

	if ($code != 200) {
		$param = null;
		$error = 'EPAYPAL';
		return array($param, $error);
	}

	$param_array = explode("\n", $response);
	if ($param_array[0] != 'SUCCESS') {
		$param = null;
		$error = $param_array[0];
		return array($param, $error);
	}

	parse_str(implode('&', array_slice($param_array, 1)), $param);
	$error = null;
	return array($param, $error);
}

function paypal_standard_parse($param)
{
	$order = paypal_standard_parse_order($param);
	$billing = paypal_standard_parse_billing($param);
	if (isset($billing)) {
		$order['billing'] = $billing;
		unset($billing);
	}
	$shipping = paypal_standard_parse_shipping($param);
	if (isset($shipping)) {
		$order['shipping'] = $shipping;
		unset($shipping);
	}
	$tax = paypal_standard_parse_tax($param);
	if (isset($tax)) {
		$order['tax'] = $tax;
		unset($tax);
	}
	return $order;
}

function paypal_standard_add_order($param, $order)
{
	$param['item_number'] = $order['id'];
	$param['item_name'] = $order['title'];
	$param['amount'] = $order['amount'];
	$param['currency_code'] = $order['currency'];
	$param['no_shipping'] = 1;
	return $param;
}

function paypal_standard_parse_order($param)
{
	return array(
		'id' => $param['item_number'],
		'title' => $param['item_name'],
		'description' => null,
		'amount' => $param['mc_gross'],
		'currency' => $param['mc_currency'],
	);
}

function paypal_standard_add_billing($param, $order)
{
	# PayPal Payments Standard does not have billing
	return $param;
}

function paypal_standard_parse_billing($param)
{
	return array(
		'first_name' => $param['first_name'],
		'last_name' => $param['last_name'],
		'country_code' => null,
		'state_code' => null,
		'province' => null,
		'city' => null,
		'zip_code' => null,
		'address' => null,
		'address2' => null,
		'company' => null,
		'phone' => null,
		'email' => $param['payer_email'],
	);
}

function paypal_standard_add_shipping($param, $order)
{
	if (!isset($param['amount'])) {
		trigger_error('paypal_standard_add_order() was not called', E_USER_ERROR);
	}

	$param['amount'] -= $order['shipping']['amount'];
	$param['shipping'] = $order['shipping']['amount'];
	$param['address_override'] = 1;
	unset($param['no_shipping']);

	# Address will be used on the following tab:
	#
	#	Pay with a debit or credit card
	#	(Optional) Join PayPal for faster future checkout
	#
	$param['first_name'] = $order['shipping']['first_name'];
	$param['last_name'] = $order['shipping']['last_name'];
	$param['country'] = $order['shipping']['country_code'];
	if (empty($order['shipping']['state_code'])) {
		$param['state'] = $order['shipping']['province'];
	}
	else {
		$param['state'] = $order['shipping']['state_code'];
	}
	$param['city'] = $order['shipping']['city'];
	$param['zip'] = $order['shipping']['zip_code'];
	$param['address1'] = $order['shipping']['address'];
	$param['address2'] = $order['shipping']['address2'];
	$param['night_phone_b'] = $order['shipping']['phone'];
	$param['email'] = $order['shipping']['email'];

	return $param;
}

function paypal_standard_parse_shipping($param)
{
	if (isset($param['address_country_code'])) {
		$shipping = array();
		$shipping['title'] = null;
		$shipping['amount'] = $param['shipping'];
		list($shipping['first_name'], $shipping['last_name']) = parse_name($param['address_name']);
		$shipping['country_code'] = $param['address_country_code'];
		$shipping['state_code'] = $param['address_state'];
		$shipping['province'] = null;
		$shipping['city'] = $param['address_city'];
		$shipping['zip_code'] = $param['address_zip'];
		list($shipping['address'], $shipping['address2']) = explode("\n", $param['address_street']."\n");
		$shipping['address'] = trim($shipping['address']);
		$shipping['address2'] = trim($shipping['address2']);
		$shipping['company'] = null;
		$shipping['phone'] = null;
		$shipping['email'] = $param['payer_email'];
		return $shipping;
	}
	return null;
}

function paypal_standard_add_tax($param, $order)
{
	if (!isset($param['amount'])) {
		trigger_error('paypal_standard_add_order() was not called', E_USER_ERROR);
	}
	$param['amount'] -= $order['tax']['amount'];
	$param['tax'] = $order['tax']['amount'];
	return $param;
}

function paypal_standard_parse_tax($param)
{
	if (isset($param['tax'])) {
		return array('amount' => $param['tax']);
	}
	return null;
}
