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
# payer_email=xxxxxxxx%40yyyyyyyyyy.zzz
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
