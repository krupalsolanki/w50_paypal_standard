<?php

# PayPal Payments Standard
# https://www.paypal.com/webapps/mpp/paypal-payments-standard

# PayPal Payments Standard Overview
# https://developer.paypal.com/webapps/developer/docs/classic/paypal-payments-standard/integration-guide/wp_standard_overview/

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

# HTML Variables for PayPal Payments Standard 
# https://developer.paypal.com/webapps/developer/docs/classic/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables/
$param = array();
$param['business'] = $config['business'];
$param['cmd'] = '_xclick';

# HTML Variables for Individual Items
# https://developer.paypal.com/webapps/developer/docs/classic/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables/#id08A6HF080O3
$param['item_name'] = $order_title;
$param['amount'] = $order_amount;

# HTML Variables for Payment Transactions 
# https://developer.paypal.com/webapps/developer/docs/classic/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables/#id08A6HH00W2J
$param['invoice'] = $order_id;
$param['currency_code'] = $order_currency;

# HTML Variables for Displaying PayPal Checkout Pages
# https://developer.paypal.com/webapps/developer/docs/classic/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables/#id08A6HI0709B
$param['no_note'] = 1;
$param['no_shipping'] = 1;

# HTML Variables for Displaying PayPal Checkout Pages
# https://developer.paypal.com/webapps/developer/docs/classic/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables/#id08A6HI0709B
$param['rm'] = 2;
$param['cbt'] = '[return]'; 
$param['return'] = dirname(script_url()).'/standard_pdt_off_confirm.php';
$param['cancel_return'] = dirname(script_url()).'/standard_pdt_off_cancel.php';
# HTML Variables for PayPal Payments Standard 
# https://developer.paypal.com/webapps/developer/docs/classic/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables/
$param['notify_url'] = dirname(script_url()).'/standard_ipn.php';

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Title of the Page</title>
</head>
<body>

<form action="<?php echo $config['www_endpoint'] ?>" method="POST">
	<?php foreach ($param as $key => $val): ?>
		<input type="hidden" name="<?php echo $key ?>" value="<?php echo $val ?>">
	<?php endforeach ?>
	<input type="submit">
</form>
<script type="text/javascript">
document.getElementsByTagName('form').item(document.getElementsByTagName('form').length - 1).submit();
</script>

</body>
</html>
