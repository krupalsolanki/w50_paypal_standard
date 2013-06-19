<?php

require 'config.php';
require 'core.php';

header('Content-Type: text/plain; charset=utf-8');

$param = $_POST;
echo 'validate_ipn', PHP_EOL;
var_dump(validate_ipn($param, $config));
echo PHP_EOL;

echo '$_GET', PHP_EOL;
print_r($_GET);
echo PHP_EOL;

echo '$_POST', PHP_EOL;
print_r($_POST);
echo PHP_EOL;

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

# shipping=false
# rm=0, rm=1
#
# $_GET
# Array
# (
# )
#
# $_POST
# Array
# (
# )

# shipping=false
# rm=2
#
# $_GET
# Array
# (
# )
#
# $_POST
# Array
# (
#     [mc_gross] => 12.99
#     [invoice] => ORDER-1371577780
#     [protection_eligibility] => Ineligible
#     [payer_id] => DWVKB2V8CDG82
#     [tax] => 0.00
#     [payment_date] => 10:50:05 Jun 18, 2013 PDT
#     [payment_status] => Completed
#     [charset] => windows-1252
#     [first_name] => Personal
#     [mc_fee] => 0.68
#     [notify_version] => 3.7
#     [custom] =>
#     [payer_status] => verified
#     [business] => xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx@yyyyy.zzz
#     [quantity] => 1
#     [payer_email] => xxxxxxxx@yyyyyyyyyy.zzz
#     [verify_sign] => AFw1Uv51K5e5A16q5nu6MpAyG.rUAeVbxcQhHfGGHOhCTsUnn4C.kTJL
#     [txn_id] => 25F517709V510362A
#     [payment_type] => instant
#     [last_name] => Account
#     [receiver_email] => xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx@yyyyy.zzz
#     [payment_fee] => 0.68
#     [receiver_id] => SBJREX8EW2BTG
#     [txn_type] => web_accept
#     [item_name] => Order #1371577780
#     [mc_currency] => USD
#     [item_number] =>
#     [residence_country] => US
#     [test_ipn] => 1
#     [handling_amount] => 0.00
#     [transaction_subject] => Order #1371577780
#     [payment_gross] => 12.99
#     [shipping] => 0.00
#     [merchant_return_link] => click here
#     [auth] => ALH-NZ2MtZAyG9DmrUmp7FH3IK9nTjlr6nsTqOWCT4G3434q8yNQtaM0k9enbeov3mH6dFjBVOfRFjJhI5rPBqA
#     [form_charset] => UTF-8
# )

# shipping=true
# rm=0, rm=1
#
# $_GET
# Array
# (
# )
#
# $_POST
# Array
# (
# )

# shipping=true
# rm=2
#
# $_GET
# Array
# (
# )
#
# $_POST
# Array
# (
#     [mc_gross] => 17.99
#     [invoice] => ORDER-1371654715
#     [protection_eligibility] => Eligible
#     [address_status] => confirmed
#     [payer_id] => DWVKB2V8CDG82
#     [tax] => 0.00
#     [address_street] => 1028 Terra Cotta Street
# 2nd Flat
#     [payment_date] => 08:12:12 Jun 19, 2013 PDT
#     [payment_status] => Completed
#     [charset] => windows-1252
#     [address_zip] => 56623
#     [first_name] => Personal
#     [mc_fee] => 0.82
#     [address_country_code] => US
#     [address_name] => Pete Russo
#     [notify_version] => 3.7
#     [custom] =>
#     [payer_status] => verified
#     [business] => xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx@yyyyy.zzz
#     [address_country] => United States
#     [address_city] => Baudette
#     [quantity] => 1
#     [payer_email] => xxxxxxxx@yyyyyyyyyy.zzz
#     [verify_sign] => AE7uG5DaTb1N35RXs6qvTYhnNwAtAQllJiCmX-fX-oikN5QrQTKqOaF8
#     [txn_id] => 2H77480225443583Y
#     [payment_type] => instant
#     [last_name] => Account
#     [address_state] => MN
#     [receiver_email] => xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx@yyyyy.zzz
#     [payment_fee] => 0.82
#     [receiver_id] => SBJREX8EW2BTG
#     [txn_type] => web_accept
#     [item_name] => Order #1371654715
#     [mc_currency] => USD
#     [item_number] =>
#     [residence_country] => US
#     [test_ipn] => 1
#     [transaction_subject] => Order #1371654715
#     [handling_amount] => 0.00
#     [payment_gross] => 17.99
#     [shipping] => 5.00
#     [merchant_return_link] => click here
#     [auth] => AxBZz.95DdobyNAA6DvTKHSWI41oqOFmNCb4CYjZww87-yL2ui9jhSLDW04LEA8eIPXY3qQQP3juwnNh3.rvfrg
#     [form_charset] => UTF-8
# )
