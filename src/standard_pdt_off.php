<?php

# PayPal Payments Standard
# https://www.paypal.com/webapps/mpp/paypal-payments-standard

# PayPal Payments Standard Overview
# https://developer.paypal.com/webapps/developer/docs/classic/paypal-payments-standard/integration-guide/wp_standard_overview/

# Website Payments Standard Integration Guide
# https://cms.paypal.com/cms_content/GB/en_GB/files/developer/PP_WebsitePaymentsStandard_IntegrationGuide.pdf

# Website Payment Preferences
# https://www.sandbox.paypal.com/us/cgi-bin/webscr?cmd=_profile-website-payments
# > Payment Data Transfer

# Differences Between PDT=ON and PTD=OFF
#
# 1. PTD=ON ignores *rm* parameter.
# 2. PTD=OFF with notify_url parameter specified implies rm=2. The
#    *return* script will receive the same parameters which
#    *notify_url* will receive.

require 'config.php';
require 'core.php';

$order_id = 'ORDER-'.time();
$order_title = 'Order #'.time();
$order_description = 'Praesent dignissim lobortis erat vitae elementum. Ut hendrerit ullamcorper diam, quis laoreet risus adipiscing vitae.';
$order_amount = 12.99;
$order_currency = 'USD';

$shipping = true; # enable/disable shipping
$shipping_title = 'Flat Rate';
$shipping_amount = 5.00;
$shipping_currency = 'USD';

# Generate a Random Name - Fake Name Generator
# http://www.fakenamegenerator.com/gen-random-us-us.php
$billing_first_name = 'Janet';
$billing_last_name = 'Cruz';
$billing_middle_name = 'James';
$billing_country = 'United States';
$billing_state = 'Illinois';
$billing_city = 'Oak Brook';
$billing_zip = '60523';
$billing_address_1 = '2796 Steele Street';
$billing_address_2 = '1st Flat';
$billing_phone = '630-634-1799';
$billing_email = 'vladimir.barbarosh@gmail.com';

# Generate a Random Name - Fake Name Generator
# http://www.fakenamegenerator.com/gen-random-us-us.php
$shipping_first_name = 'Pete';
$shipping_last_name = 'Russo';
$shipping_middle_name = 'Klay';
$shipping_country = 'United States';
$shipping_state = 'Minnesota';
$shipping_city = 'Baudette';
$shipping_zip = '56623';
$shipping_address_1 = '1028 Terra Cotta Street';
$shipping_address_2 = '2nd Flat';
$shipping_phone = '218-634-5672';
$shipping_email = 'vladimir.barbarosh@gmail.com';

# HTML Variables for PayPal Payments Standard
# https://developer.paypal.com/webapps/developer/docs/classic/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables/
$param = array();
$param['business'] = $config['business'];
$param['cmd'] = '_xclick';

# HTML Variables for Individual Items
# https://developer.paypal.com/webapps/developer/docs/classic/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables/#id08A6HF080O3
$param['item_name'] = $order_title;
$param['amount'] = $order_amount;
if ($shipping) {
	$param['shipping'] = $shipping_amount;
}

# HTML Variables for Payment Transactions
# https://developer.paypal.com/webapps/developer/docs/classic/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables/#id08A6HH00W2J
$param['invoice'] = $order_id;
$param['currency_code'] = $order_currency;
if ($shipping) {
	assert($order_currency == $shipping_currency);
}

# HTML Variables for Displaying PayPal Checkout Pages
# https://developer.paypal.com/webapps/developer/docs/classic/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables/#id08A6HI0709B
$param['no_note'] = 1;
if (!$shipping) {
	$param['no_shipping'] = 1;
}

# HTML Variables for Displaying PayPal Checkout Pages
# https://developer.paypal.com/webapps/developer/docs/classic/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables/#id08A6HI0709B
$param['rm'] = 2;
$param['cbt'] = '[return]';
$param['return'] = dirname(script_url()).'/standard_pdt_off_confirm.php';
$param['cancel_return'] = dirname(script_url()).'/standard_pdt_off_cancel.php';
# HTML Variables for PayPal Payments Standard
# https://developer.paypal.com/webapps/developer/docs/classic/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables/
$param['notify_url'] = dirname(script_url()).'/standard_ipn.php';

# HTML Variables for Filling Out PayPal Checkout Pages Automatically
# https://developer.paypal.com/webapps/developer/docs/classic/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables/#id08A6HI0J0VU
#
# Pre-Populate Your Customer's PayPal Sign-Up
# https://www.paypal.com/uk/cgi-bin/webscr?cmd=_pdn_xclick_prepopulate_outside
if ($shipping) {
	$param['address_override'] = 1;
}
else {
	# Address will be used on the following tab:
	#
	#	Pay with a debit or credit card
	#	(Optional) Join PayPal for faster future checkout
}
$param['first_name'] = $shipping_first_name;
$param['last_name'] = $shipping_last_name;
$param['country'] = @abbreviate_country($shipping_country);
$param['state'] = @abbreviate_state($shipping_state);
$param['city'] = $shipping_city;
$param['zip'] = $shipping_zip;
$param['address1'] = $shipping_address_1;
$param['address2'] = $shipping_address_2;
$param['night_phone_b'] = $shipping_phone; # TODO night_phone_a, night_phone_b, night_phone_c
$param['email'] = $shipping_email;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Title of the Page</title>
</head>
<body>

You will be redirected to the PayPal website in a few seconds.
<form action="<?php echo $config['www_endpoint'] ?>" method="POST">
	<?php foreach ($param as $key => $val): ?>
		<input type="hidden" name="<?php echo $key ?>" value="<?php echo $val ?>">
	<?php endforeach ?>
	<input type="submit" value="Click here if you are not redirected within 10 seconds...">
</form>
<script type="text/javascript">
document.getElementsByTagName('form').item(document.getElementsByTagName('form').length - 1).submit();
</script>

</body>
</html>
