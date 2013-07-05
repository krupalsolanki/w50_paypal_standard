<?php

$config = array();

# PayPal Payments Standard
# ========================

# Sandbox Test Accounts
# https://developer.paypal.com/webapps/developer/applications/accounts
$config['business'] = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx@xxxxx.com';
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

# I search for reference for www_endpoint config parameter. I want to
# find central place for sandbox and live endpoints.
#
# https://developer.paypal.com/webapps/developer/docs/classic/express-checkout/ht_ec-singleItemPayment-curl-etc/
# > https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=<tokenValue>
#
# https://developer.paypal.com/webapps/developer/docs/classic/button-manager/integration-guide/NVP/ButtonMgrOverview/
# > https://www.sandbox.paypal.com/cgi-bin/webscr
#
# https://developer.paypal.com/webapps/developer/docs/classic/express-checkout/integration-guide/ECGettingStarted/
# > https://www.sandbox.paypal.com/cgi-bin/webscr
#
# https://developer.paypal.com/webapps/developer/docs/classic/paypal-payments-standard/ht_test-pps-buttons/
# > https://www.sandbox.paypal.com/cgi-bin/webscr
#
# https://developer.paypal.com/webapps/developer/docs/classic/express-checkout/ht_ec-recurringPaymentProfile-curl-etc/
# > https://www.sandbox.paypal.com/cgi-bin/webscr
#
# https://developer.paypal.com/webapps/developer/docs/classic/permissions-service/gs_PermissionsService/
# > https://www.sandbox.paypal.com/cgi-bin/webscr
#
# https://developer.paypal.com/webapps/developer/docs/classic/ipn/integration-guide/IPNIntro/
# > https://www.sandbox.paypal.com/cgi-bin/webscr
#
# https://developer.paypal.com/webapps/developer/docs/classic/adaptive-payments/ht_ap-parallelPayment-curl-etc/
# > https://www.sandbox.paypal.com/cgi-bin/webscr
#
# https://developer.paypal.com/webapps/developer/docs/classic/paypal-payments-standard/gs_PayPalPaymentsStandard/
# > https://www.sandbox.paypal.com/cgi-bin/webscr
#
# https://developer.paypal.com/webapps/developer/docs/classic/permissions-service/ht_permissions-invoice/
# > https://www.sandbox.paypal.com/cgi-bin/webscr
#
# https://developer.paypal.com/webapps/developer/docs/integration/web/accept-paypal-payment/
# > https://www.sandbox.paypal.com/webscr
