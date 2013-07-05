<?php

#    Order $12.99
# Shipping  $5.00
#      Tax  $2.11
# ---------------
#    Total $20.10

return array(
	'id' => time(),
	'title' => 'Order #'.time(),
	'description' => 'Suspendisse vitae tincidunt turpis, porttitor euismod urna. Quisque rhoncus, nulla congue ullamcorper ultricies, est ipsum vulputate ante, sit amet tincidunt metus augue ut erat.',
	'amount' => 20.10,
	'currency' => 'USD',
	# Generate a Random Name - Fake Name Generator
	# http://www.fakenamegenerator.com/gen-random-us-us.php
	'billing' => array(
		'first_name' => 'Janet',
		'last_name' => 'Cruz',
		'country_code' => 'US',
		'state_code' => 'IL',
		'province' => '',
		'city' => 'Oak Brook',
		'zip_code' => '60523',
		'address' => '2796 Steele Street',
		'address2' => '1st Flat',
		'company' => '',
		'phone' => '630-634-1799',
		'email' => 'vladimir.barbarosh@gmail.com',
	),
	# Generate a Random Name - Fake Name Generator
	# http://www.fakenamegenerator.com/gen-random-us-us.php
	'shipping' => array(
		'title' => 'Flat Rate',
		'amount' => 5,
		'first_name' => 'Peter',
		'last_name' => 'Russo',
		'country_code' => 'US',
		'state_code' => 'MN',
		'province' => '',
		'city' => 'Baudette',
		'zip_code' => '56623',
		'address' => '1028 Terra Cotta Street',
		'address2' => '2nd Flat',
		'company' => '',
		'phone' => '218-634-5672',
		'email' => 'vladimir.barbarosh@gmail.com',
	),
	'tax' => array(
		'amount' => 2.11,
	),
);
