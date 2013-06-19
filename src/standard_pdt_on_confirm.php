<?php

# Payment Data Transfer
# https://developer.paypal.com/webapps/developer/docs/classic/paypal-payments-standard/integration-guide/paymentdatatransfer/

require 'config.php';
require 'core.php';

header('Content-Type: text/plain; charset=utf-8');

echo '$_GET', PHP_EOL;
print_r($_GET);
echo PHP_EOL;

echo '$_POST', PHP_EOL;
print_r($_POST);
echo PHP_EOL;

$param = array();
$param['cmd'] = '_notify-synch';
$param['tx'] = $_GET['tx'];
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

if ($errno == 0 && $code == 200) {
	# ...
}

echo '$errno', PHP_EOL;
var_dump($errno);
echo PHP_EOL;

echo '$code', PHP_EOL;
var_dump($code);
echo PHP_EOL;

echo '$response', PHP_EOL;
var_dump($response);
echo PHP_EOL;

$param_array = explode("\n", $response);
if ($param_array[0] == 'SUCCESS') {

	parse_str(implode('&', array_slice($param_array, 1)), $param);

	$order_id = $param['invoice'];
	$order_title = $param['item_name'];
	$order_description = null;
	$order_amount = $param['mc_gross'];
	$order_currency = $param['mc_currency'];

	$shipping = isset($param['address_country']);
	if ($shipping) {
		$shipping_title = null;
		$shipping_amount = $param['shipping'];
		$shipping_currency = $param['mc_currency'];
		$order_amount -= $shipping_amount;
	}

	$billing_first_name = null;
	$billing_last_name = null;
	$billing_middle_name = null;
	$billing_country = null;
	$billing_state = null;
	$billing_city = null;
	$billing_zip = null;
	$billing_address_1 = null;
	$billing_address_2 = null;
	$billing_phone = null;
	$billing_email = null;

	if ($shipping) {
		# guessing
		$shipping_name = explode(' ', $param['address_name']);
		switch (count($shipping_name)) {
		case 1:
			$shipping_first_name = null;
			$shipping_last_name = $shipping_name[0];
			$shipping_middle_name = null;
			break;
		case 2:
			$shipping_first_name = $shipping_name[0];
			$shipping_last_name = $shipping_name[1];
			$shipping_middle_name = null;
			break;
		default:
			$shipping_first_name = $shipping_name[0];
			$shipping_last_name = $shipping_name[count($shipping_name)-1];
			$shipping_middle_name = implode(' ', array_slice($shipping_name, 1, -1));
			break;
		}
		unset($shipping_name);
		$shipping_country = $param['address_country'];
		$shipping_state = $param['address_state'];
		$shipping_city = $param['address_city'];
		$shipping_zip = $param['address_zip'];

		$shipping_address = explode("\n", $param['address_street']);
		$shipping_address_1 = $shipping_address[0];
		$shipping_address_2 = @$shipping_address[1];
		unset($shipping_address);

		$shipping_phone = null;
		$shipping_email = null;
	}

	$var = array();
	foreach ($GLOBALS as $key => $val) {
		if (preg_match('/^order|^billing|^shipping/', $key)) {
			$var[$key] = $val;
		}
	}
	print_r($var);
}

# shipping=false
#
# $_GET
# Array
# (
#     [tx] => 0V895313R2304124G
#     [st] => Completed
#     [amt] => 12.99
#     [cc] => USD
#     [cm] =>
#     [item_number] =>
# )
#
# $_POST
# Array
# (
# )

# shipping=false
#
# $errno
# int(0)
#
# $code
# int(200)
#
# $response
# string(728) "SUCCESS
# transaction_subject=Order+%231371578545
# payment_date=11%3A02%3A40+Jun+18%2C+2013+PDT
# txn_type=web_accept
# last_name=Account
# residence_country=US
# item_name=Order+%231371578545
# payment_gross=12.99
# mc_currency=USD
# business=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx%40yyyyy.zzz
# payment_type=instant
# protection_eligibility=Ineligible
# payer_status=verified
# tax=0.00
# payer_email=personal%40vbarbarosh.com
# txn_id=0V895313R2304124G
# quantity=1
# receiver_email=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx%40yyyyy.zzz
# first_name=Personal
# invoice=ORDER-1371578545
# payer_id=DWVKB2V8CDG82
# receiver_id=SBJREX8EW2BTG
# item_number=
# handling_amount=0.00
# payment_status=Completed
# payment_fee=0.68
# mc_fee=0.68
# shipping=0.00
# mc_gross=12.99
# custom=
# charset=windows-1252
# "

# $errno
# int(0)
#
# $code
# int(200)
#
# $response
# string(16) "FAIL
# Error: 4002"

# shipping=true
#
# $_GET
# Array
# (
#     [tx] => 5VW19026P41190223
#     [st] => Completed
#     [amt] => 17.99
#     [cc] => USD
#     [cm] =>
#     [item_number] =>
# )
#
# $_POST
# Array
# (
# )

# shipping=true
#
# $errno
# int(0)
#
# $code
# int(200)
#
# $response
# string(939) "SUCCESS
# mc_gross=17.99
# invoice=ORDER-1371655929
# protection_eligibility=Eligible
# address_status=confirmed
# payer_id=DWVKB2V8CDG82
# tax=0.00
# address_street=1028+Terra+Cotta+Street%0D%0A2nd+Flat
# payment_date=08%3A32%3A34+Jun+19%2C+2013+PDT
# payment_status=Completed
# charset=windows-1252
# address_zip=56623
# first_name=Personal
# mc_fee=0.82
# address_country_code=US
# address_name=Pete+Russo
# custom=
# payer_status=verified
# business=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx%40yyyyy.zzz
# address_country=United+States
# address_city=Baudette
# quantity=1
# payer_email=xxxxxxxx%40yyyyyyyyyy.zzz
# txn_id=5VW19026P41190223
# payment_type=instant
# last_name=Account
# address_state=MN
# receiver_email=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx%40yyyyy.zzz
# payment_fee=0.82
# receiver_id=SBJREX8EW2BTG
# txn_type=web_accept
# item_name=Order+%231371655929
# mc_currency=USD
# item_number=
# residence_country=US
# handling_amount=0.00
# transaction_subject=Order+%231371655929
# payment_gross=17.99
# shipping=5.00
# "
