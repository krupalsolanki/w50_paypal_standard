<?php

# Payment Data Transfer
# https://developer.paypal.com/webapps/developer/docs/classic/paypal-payments-standard/integration-guide/paymentdatatransfer/

# PDT-Specific Variables
# https://developer.paypal.com/webapps/developer/docs/classic/ipn/integration-guide/IPNandPDTVariables/#id092BE0U605Z

require 'config.php';
require 'core.php';

header('Content-Type: text/plain; charset=utf-8');

echo '$_GET', PHP_EOL;
print_r($_GET);
echo PHP_EOL;

echo '$_POST', PHP_EOL;
print_r($_POST);
echo PHP_EOL;

list($param, $error) = paypal_standard_pdt_get($_GET['tx'], $config);
if (isset($param)) {

	$order = paypal_standard_parse($param);

	echo '$param', PHP_EOL;
	print_r($param);
	echo PHP_EOL;

	echo '$order', PHP_EOL;
	print_r($order);
	echo PHP_EOL;
}

# shipping=true tax=true
#
# $_GET
# Array
# (
#     [tx] => 94U96802XH400571R
#     [st] => Completed
#     [amt] => 20.10
#     [cc] => USD
#     [cm] => 
#     [item_number] => 1372849733
# )
# 
# $_POST
# Array
# (
# )
# 
# $param
# Array
# (
#     [mc_gross] => 20.10
#     [protection_eligibility] => Eligible
#     [address_status] => confirmed
#     [payer_id] => DWVKB2V8CDG82
#     [tax] => 2.11
#     [address_street] => 1028 Terra Cotta Street
# 2nd Flat
#     [payment_date] => 04:09:07 Jul 03, 2013 PDT
#     [payment_status] => Completed
#     [charset] => windows-1252
#     [address_zip] => 56623
#     [first_name] => Personal
#     [mc_fee] => 0.88
#     [address_country_code] => US
#     [address_name] => Peter Russo
#     [custom] => 
#     [payer_status] => verified
#     [business] => xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx@xxxxx.com
#     [address_country] => United States
#     [address_city] => Baudette
#     [quantity] => 1
#     [payer_email] => xxxxxxxx@xxxxxxxxxx.com
#     [txn_id] => 94U96802XH400571R
#     [payment_type] => instant
#     [last_name] => Account
#     [address_state] => MN
#     [receiver_email] => xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx@xxxxx.com
#     [payment_fee] => 0.88
#     [receiver_id] => SBJREX8EW2BTG
#     [txn_type] => web_accept
#     [item_name] => Order #1372849733
#     [mc_currency] => USD
#     [item_number] => 1372849733
#     [residence_country] => US
#     [handling_amount] => 0.00
#     [transaction_subject] => Order #1372849733
#     [payment_gross] => 20.10
#     [shipping] => 5.00
# )
# 
# $order
# Array
# (
#     [id] => 1372849733
#     [title] => Order #1372849733
#     [description] => 
#     [amount] => 20.10
#     [currency] => USD
#     [billing] => Array
#         (
#             [first_name] => Personal
#             [last_name] => Account
#             [country_code] => 
#             [state_code] => 
#             [province] => 
#             [city] => 
#             [zip_code] => 
#             [address] => 
#             [address2] => 
#             [company] => 
#             [phone] => 
#             [email] => xxxxxxxx@xxxxxxxxxx.com
#         )
# 
#     [shipping] => Array
#         (
#             [title] => 
#             [amount] => 5.00
#             [last_name] => Russo
#             [first_name] => Peter
#             [country_code] => US
#             [state_code] => MN
#             [province] => 
#             [city] => Baudette
#             [zip_code] => 56623
#             [address2] => 2nd Flat
#             [address] => 1028 Terra Cotta Street
#             [company] => 
#             [phone] => 
#             [email] => xxxxxxxx@xxxxxxxxxx.com
#         )
# 
#     [tax] => Array
#         (
#             [amount] => 2.11
#         )
# 
# )

# shipping=false
#
# $_GET
# Array
# (
#     [tx] => 3MB17600435434403
#     [st] => Completed
#     [amt] => 20.10
#     [cc] => USD
#     [cm] => 
#     [item_number] => 1372849645
# )
# 
# $_POST
# Array
# (
# )
# 
# $param
# Array
# (
#     [transaction_subject] => Order #1372849645
#     [payment_date] => 04:07:43 Jul 03, 2013 PDT
#     [txn_type] => web_accept
#     [last_name] => Account
#     [residence_country] => US
#     [item_name] => Order #1372849645
#     [payment_gross] => 20.10
#     [mc_currency] => USD
#     [business] => xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx@xxxxx.com
#     [payment_type] => instant
#     [protection_eligibility] => Ineligible
#     [payer_status] => verified
#     [tax] => 2.11
#     [payer_email] => xxxxxxxx@xxxxxxxxxx.com
#     [txn_id] => 3MB17600435434403
#     [quantity] => 1
#     [receiver_email] => xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx@xxxxx.com
#     [first_name] => Personal
#     [payer_id] => DWVKB2V8CDG82
#     [receiver_id] => SBJREX8EW2BTG
#     [item_number] => 1372849645
#     [handling_amount] => 0.00
#     [payment_status] => Completed
#     [payment_fee] => 0.88
#     [mc_fee] => 0.88
#     [shipping] => 0.00
#     [mc_gross] => 20.10
#     [custom] => 
#     [charset] => windows-1252
# )
# 
# $order
# Array
# (
#     [id] => 1372849645
#     [title] => Order #1372849645
#     [description] => 
#     [amount] => 20.10
#     [currency] => USD
#     [billing] => Array
#         (
#             [first_name] => Personal
#             [last_name] => Account
#             [country_code] => 
#             [state_code] => 
#             [province] => 
#             [city] => 
#             [zip_code] => 
#             [address] => 
#             [address2] => 
#             [company] => 
#             [phone] => 
#             [email] => xxxxxxxx@xxxxxxxxxx.com
#         )
# 
#     [tax] => Array
#         (
#             [amount] => 2.11
#         )
# 
# )
