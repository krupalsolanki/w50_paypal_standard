<?php

$config = array();

# Sandbox Test Accounts
# https://developer.paypal.com/webapps/developer/applications/accounts
$config['business'] = 'xxxxxxxxxxxxxxxxxxxxxxxxxxx@yyyyy.zzz';
# My business info --- My Profile
# https://www.sandbox.paypal.com/us/cgi-bin/webscr?cmd=_profile-summary
# > Merchant account ID
$config['business'] = 'xxxxxxxxxxxxx';

# HTML Form Basics for PayPal Payments Standard
# https://developer.paypal.com/webapps/developer/docs/classic/paypal-payments-standard/integration-guide/formbasics/
$config['www_endpoint'] = 'https://www.paypal.com/cgi-bin/webscr';
# How to Test PayPal Payments Standard Buttons
# https://developer.paypal.com/webapps/developer/docs/classic/paypal-payments-standard/ht_test-pps-buttons/
$config['www_endpoint'] = 'https://www.sandbox.paypal.com/cgi-bin/webscr';

# Website Payment Preferences
# https://www.sandbox.paypal.com/us/cgi-bin/webscr?cmd=_profile-website-payments
# > Payment Data Transfer
$config['pdt_token'] = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
