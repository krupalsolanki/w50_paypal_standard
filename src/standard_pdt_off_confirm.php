<?php

require 'config.php';
require 'core.php';

header('Content-Type: text/plain; charset=utf-8');

echo 'validate_ipn', PHP_EOL;
var_dump(validate_ipn($_POST, $config));
echo PHP_EOL;

echo '$_GET', PHP_EOL;
print_r($_GET);
echo PHP_EOL;

echo '$_POST', PHP_EOL;
print_r($_POST);
echo PHP_EOL;

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
