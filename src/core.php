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
