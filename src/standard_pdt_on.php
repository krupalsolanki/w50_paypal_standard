<?php

# NOTE
# Payment Data Transfer (PDT) does not work locally on host other than
# localhost, e.g. I have *home* alias to 127.0.0.1 in /etc/hosts.
#
#	http://home/path/to/standard_pdt_on.php
#	does not work
#
#	http://localhost/path/to/standard_pdt_on.php
#	works

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

# HTML Variables for PayPal Payments Standard
# https://developer.paypal.com/webapps/developer/docs/classic/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables

require 'config.php';
require 'core.php';

$order = include 'order.php';

# setup
$param = array();
$param['business'] = $config['business'];
$param['cmd'] = '_xclick';

# order, billing, shipping, and tax
$param = paypal_standard_add_order($param, $order);
if (isset($order['billing'])) {
	$param = paypal_standard_add_billing($param, $order);
}
if (isset($order['shipping'])) {
	$param = paypal_standard_add_shipping($param, $order);
}
if (isset($order['tax'])) {
	$param = paypal_standard_add_tax($param, $order);
}

# endpoint
$param['return'] = dirname(script_url()).'/standard_pdt_on_confirm.php';
$param['cancel_return'] = dirname(script_url()).'/standard_pdt_on_cancel.php';
$param['notify_url'] = dirname(script_url()).'/standard_ipn.php';
$param['notify_url'] = 'http://requestb.in/xxxxxxxx';

# etc.
$param['no_note'] = 1;

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
