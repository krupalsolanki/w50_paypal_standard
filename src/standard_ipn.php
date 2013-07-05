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

$order = paypal_standard_parse($param);

echo '$order', PHP_EOL;
print_r($order);
echo PHP_EOL;

# shipping=true tax=true
#
# validate_ipn
# NULL
#
# $_GET
# Array
# (
# )
#
# $_POST
# Array
# (
#     [mc_gross] => 20.10
#     [protection_eligibility] => Eligible
#     [address_status] => confirmed
#     [payer_id] => DWVKB2V8CDG82
#     [tax] => 2.11
#     [address_street] => 1028 Terra Cotta Street
# 2nd Flat
#     [payment_date] => 08:57:05 Jul 03, 2013 PDT
#     [payment_status] => Completed
#     [charset] => windows-1252
#     [address_zip] => 56623
#     [first_name] => Personal
#     [mc_fee] => 0.88
#     [address_country_code] => US
#     [address_name] => Peter Russo
#     [notify_version] => 3.7
#     [custom] =>
#     [payer_status] => verified
#     [business] => xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx@xxxxx.com
#     [address_country] => United States
#     [address_city] => Baudette
#     [quantity] => 1
#     [verify_sign] => AFcWxV21C7fd0v3bYYYRCpSSRl31AyvnSuXScka8UM5LHyV-ALPyaIHd
#     [payer_email] => xxxxxxxx@xxxxxxxxxx.com
#     [txn_id] => 7VN89114KM9964042
#     [payment_type] => instant
#     [last_name] => Account
#     [address_state] => MN
#     [receiver_email] => xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx@xxxxx.com
#     [payment_fee] => 0.88
#     [receiver_id] => SBJREX8EW2BTG
#     [txn_type] => web_accept
#     [item_name] => Order #1372867010
#     [mc_currency] => USD
#     [item_number] => 1372867010
#     [residence_country] => US
#     [test_ipn] => 1
#     [handling_amount] => 0.00
#     [transaction_subject] => Order #1372867010
#     [payment_gross] => 20.10
#     [shipping] => 5.00
#     [ipn_track_id] => fcad37c56950
# )
#
# $order
# Array
# (
#     [id] => 1372867010
#     [title] => Order #1372867010
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

# shipping=false tax=false
#
# validate_ipn
# NULL
#
# $_GET
# Array
# (
# )
#
# $_POST
# Array
# (
#     [mc_gross] => 20.10
#     [protection_eligibility] => Ineligible
#     [payer_id] => DWVKB2V8CDG82
#     [tax] => 0.00
#     [payment_date] => 09:08:55 Jul 03, 2013 PDT
#     [payment_status] => Completed
#     [charset] => windows-1252
#     [first_name] => Personal
#     [mc_fee] => 0.88
#     [notify_version] => 3.7
#     [custom] =>
#     [payer_status] => verified
#     [business] => xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx@xxxxx.com
#     [quantity] => 1
#     [verify_sign] => An5ns1Kso7MWUdW4ErQKJJJ4qi4-ANMSH4.7KtdsL2UAm4IzgnhEpX9k
#     [payer_email] => xxxxxxxx@xxxxxxxxxx.com
#     [txn_id] => 12N22287J18419148
#     [payment_type] => instant
#     [last_name] => Account
#     [receiver_email] => xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx@xxxxx.com
#     [payment_fee] => 0.88
#     [receiver_id] => SBJREX8EW2BTG
#     [txn_type] => web_accept
#     [item_name] => Order #1372867723
#     [mc_currency] => USD
#     [item_number] => 1372867723
#     [residence_country] => US
#     [test_ipn] => 1
#     [handling_amount] => 0.00
#     [transaction_subject] => Order #1372867723
#     [payment_gross] => 20.10
#     [shipping] => 0.00
#     [ipn_track_id] => 894890a9df131
# )
#
# $order
# Array
# (
#     [id] => 1372867723
#     [title] => Order #1372867723
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
#             [amount] => 0.00
#         )
#
# )
