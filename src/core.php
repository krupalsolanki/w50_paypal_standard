<?php

# https://raw.github.com/paypal/merchant-sdk-php/master/samples/ExpressCheckout/DGsetExpressCheckout.php
function script_url()
{
	# $protocol = 'http';
	# $domain = $_SERVER['SERVER_NAME'];
	# $port = $_SERVER['SERVER_PORT'];
	# $uri = $_SERVER['REQUEST_URI'];
	# http://home/debug/index.php?asdfsaf&asf=aa
	#	script_url: http://home/debug/index.php?asdfsaf&asf=aa
	#
	# http://home/debug/index.php?asdfsaf&asf=aa
	#	script_url: http://home/debug/index.php

	$protocol = 'http';
	$server_name = $_SERVER['SERVER_NAME'];
	$server_port = $_SERVER['SERVER_PORT'];
	$script_name = $_SERVER['SCRIPT_NAME'];

	if ($server_port == 80) {
		return "$protocol://$server_name$script_name";
	}

	return "$protocol://$server_name:$server_port$script_name";
}

function validate_ipn($ipn, $config)
{
	$param = array_merge(array('cmd' => '_notify-validate'), $ipn);

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $config['www_endpoint']);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($param));
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($curl);
	$errno = curl_errno($curl);
	$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	curl_close($curl);

	if ($errno != 0) {
		return 'ECURL';
	}
	if ($code != 200) {
		return 'EREMOTE';
	}
	if ($response != 'VERIFIED') {
		return $response;
	}

	return null;
}

# HTML Variables for Filling Out PayPal Checkout Pages Automatically
# https://developer.paypal.com/webapps/developer/docs/classic/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables/#id08A6HI0J0VU
#
#	Official USPS Abbreviations
#	https://www.usps.com/ship/official-abbreviations.htm
function abbreviate_state($state)
{
	static $tab = array(
		# State/Possession
		'ALABAMA' => 'AL',
		'ALASKA' => 'AK',
		'AMERICAN SAMOA' => 'AS',
		'ARIZONA' => 'AZ',
		'ARKANSAS' => 'AR',
		'CALIFORNIA' => 'CA',
		'COLORADO' => 'CO',
		'CONNECTICUT' => 'CT',
		'DELAWARE' => 'DE',
		'DISTRICT OF COLUMBIA' => 'DC',
		'FEDERATED STATES OF MICRONESIA' => 'FM',
		'FLORIDA' => 'FL',
		'GEORGIA' => 'GA',
		'GUAM GU' => 'GU',
		'HAWAII' => 'HI',
		'IDAHO' => 'ID',
		'ILLINOIS' => 'IL',
		'INDIANA' => 'IN',
		'IOWA' => 'IA',
		'KANSAS' => 'KS',
		'KENTUCKY' => 'KY',
		'LOUISIANA' => 'LA',
		'MAINE' => 'ME',
		'MARSHALL ISLANDS' => 'MH',
		'MARYLAND' => 'MD',
		'MASSACHUSETTS' => 'MA',
		'MICHIGAN' => 'MI',
		'MINNESOTA' => 'MN',
		'MISSISSIPPI' => 'MS',
		'MISSOURI' => 'MO',
		'MONTANA' => 'MT',
		'NEBRASKA' => 'NE',
		'NEVADA' => 'NV',
		'NEW HAMPSHIRE' => 'NH',
		'NEW JERSEY' => 'NJ',
		'NEW MEXICO' => 'NM',
		'NEW YORK' => 'NY',
		'NORTH CAROLINA' => 'NC',
		'NORTH DAKOTA' => 'ND',
		'NORTHERN MARIANA ISLANDS' => 'MP',
		'OHIO' => 'OH',
		'OKLAHOMA' => 'OK',
		'OREGON' => 'OR',
		'PALAU' => 'PW',
		'PENNSYLVANIA' => 'PA',
		'PUERTO RICO' => 'PR',
		'RHODE ISLAND' => 'RI',
		'SOUTH CAROLINA' => 'SC',
		'SOUTH DAKOTA' => 'SD',
		'TENNESSEE' => 'TN',
		'TEXAS' => 'TX',
		'UTAH' => 'UT',
		'VERMONT' => 'VT',
		'VIRGIN ISLANDS' => 'VI',
		'VIRGINIA' => 'VA',
		'WASHINGTON' => 'WA',
		'WEST VIRGINIA' => 'WV',
		'WISCONSIN' => 'WI',
		'WYOMING' => 'WY',
		# Military "State"
		'ARMED FORCES AFRICA' => 'AE',
		'ARMED FORCES AMERICAS' => 'AA',
		'ARMED FORCES CANADA' => 'AE',
		'ARMED FORCES EUROPE' => 'AE',
		'ARMED FORCES MIDDLE EAST' => 'AE',
		'ARMED FORCES PACIFIC' => 'AP',
	);
	$up = strtoupper($state);
	if (in_array($up, $tab)) {
		return $up;
	}
	if (!isset($tab[$up])) {
		trigger_error('Invalid state: '.$state, E_USER_WARNING);
		return null;
	}
	return $tab[$up];
}

# HTML Variables for Filling Out PayPal Checkout Pages Automatically
# https://developer.paypal.com/webapps/developer/docs/classic/paypal-payments-standard/integration-guide/Appx_websitestandard_htmlvariables/#id08A6HI0J0VU
#
#	Countries and Regions Supported by PayPal
#	https://developer.paypal.com/webapps/developer/docs/classic/api/country_codes/
function abbreviate_country($country)
{
	static $tab = array(
		'ALAND ISLANDS' => 'AX',
		'ALBANIA' => 'AL',
		'ALGERIA' => 'DZ',
		'AMERICAN SAMOA' => 'AS',
		'ANDORRA' => 'AD',
		'ANGUILLA' => 'AI',
		'ANTARCTICA' => 'AQ',
		'ANTIGUA AND BARBUDA' => 'AG',
		'ARGENTINA' => 'AR',
		'ARMENIA' => 'AM',
		'ARUBA' => 'AW',
		'AUSTRALIA' => 'AU',
		'AUSTRIA' => 'AT',
		'AZERBAIJAN' => 'AZ',
		'BAHAMAS' => 'BS',
		'BAHRAIN' => 'BH',
		'BANGLADESH' => 'BD',
		'BARBADOS' => 'BB',
		'BELGIUM' => 'BE',
		'BELIZE' => 'BZ',
		'BENIN' => 'BJ',
		'BERMUDA' => 'BM',
		'BHUTAN' => 'BT',
		'BOSNIA-HERZEGOVINA' => 'BA',
		'BOTSWANA' => 'BW',
		'BOUVET ISLAND' => 'BV',
		'BRAZIL' => 'BR',
		'BRITISH INDIAN OCEAN TERRITORY' => 'IO',
		'BRUNEI DARUSSALAM' => 'BN',
		'BULGARIA' => 'BG',
		'BURKINA FASO' => 'BF',
		'CANADA' => 'CA',
		'CAPE VERDE' => 'CV',
		'CAYMAN ISLANDS' => 'KY',
		'CENTRAL AFRICAN REPUBLIC' => 'CF',
		'CHILE' => 'CL',
		'CHINA' => 'CN', # CN (For domestic Chinese bank transactions only); C2 (For CUP, bank card and cross-border transactions)
		'CHRISTMAS ISLAND' => 'CX',
		'COCOS (KEELING) ISLANDS' => 'CC',
		'COLOMBIA' => 'CO',
		'COOK ISLANDS' => 'CK',
		'COSTA RICA' => 'CR',
		'CYPRUS' => 'CY',
		'CZECH REPUBLIC' => 'CZ',
		'DENMARK' => 'DK',
		'DJIBOUTI' => 'DJ',
		'DOMINICA' => 'DM',
		'DOMINICAN REPUBLIC' => 'DO',
		'ECUADOR' => 'EC',
		'EGYPT' => 'EG',
		'EL SALVADOR' => 'SV',
		'ESTONIA' => 'EE',
		'FALKLAND ISLANDS (MALVINAS)' => 'FK',
		'FAROE ISLANDS' => 'FO',
		'FIJI' => 'FJ',
		'FINLAND' => 'FI',
		'FRANCE' => 'FR',
		'FRENCH GUIANA' => 'GF',
		'FRENCH POLYNESIA' => 'PF',
		'FRENCH SOUTHERN TERRITORIES' => 'TF',
		'GABON' => 'GA',
		'GAMBIA' => 'GM',
		'GEORGIA' => 'GE',
		'GERMANY' => 'DE',
		'GHANA' => 'GH',
		'GIBRALTAR' => 'GI',
		'GREECE' => 'GR',
		'GREENLAND' => 'GL',
		'GRENADA' => 'GD',
		'GUADELOUPE' => 'GP',
		'GUAM' => 'GU',
		'GUERNSEY' => 'GG',
		'GUYANA' => 'GY',
		'HEARD ISLAND AND MCDONALD ISLANDS' => 'HM',
		'HOLY SEE (VATICAN CITY STATE)' => 'VA',
		'HONDURAS' => 'HN',
		'HONG KONG' => 'HK',
		'HUNGARY' => 'HU',
		'ICELAND' => 'IS',
		'INDIA' => 'IN',
		'INDONESIA' => 'ID',
		'IRELAND' => 'IE',
		'ISLE OF MAN' => 'IM',
		'ISRAEL' => 'IL',
		'ITALY' => 'IT',
		'JAMAICA' => 'JM',
		'JAPAN' => 'JP',
		'JERSEY' => 'JE',
		'JORDAN' => 'JO',
		'KAZAKHSTAN' => 'KZ',
		'KIRIBATI' => 'KI',
		'KOREA, REPUBLIC OF' => 'KR',
		'KUWAIT' => 'KW',
		'KYRGYZSTAN' => 'KG',
		'LATVIA' => 'LV',
		'LESOTHO' => 'LS',
		'LIECHTENSTEIN' => 'LI',
		'LITHUANIA' => 'LT',
		'LUXEMBOURG' => 'LU',
		'MACAO' => 'MO',
		'MACEDONIA' => 'MK',
		'MADAGASCAR' => 'MG',
		'MALAWI' => 'MW',
		'MALAYSIA' => 'MY',
		'MALTA' => 'MT',
		'MARSHALL ISLANDS' => 'MH',
		'MARTINIQUE' => 'MQ',
		'MAURITANIA' => 'MR',
		'MAURITIUS' => 'MU',
		'MAYOTTE' => 'YT',
		'MEXICO' => 'MX',
		'MICRONESIA, FEDERATED STATES OF' => 'FM',
		'MOLDOVA, REPUBLIC OF' => 'MD',
		'MONACO' => 'MC',
		'MONGOLIA' => 'MN',
		'MONTENEGRO' => 'ME',
		'MONTSERRAT' => 'MS',
		'MOROCCO' => 'MA',
		'MOZAMBIQUE' => 'MZ',
		'NAMIBIA' => 'NA',
		'NAURU' => 'NR',
		'NEPAL' => 'NP',
		'NETHERLANDS' => 'NL',
		'NETHERLANDS ANTILLES' => 'AN',
		'NEW CALEDONIA' => 'NC',
		'NEW ZEALAND' => 'NZ',
		'NICARAGUA' => 'NI',
		'NIGER' => 'NE',
		'NIUE' => 'NU',
		'NORFOLK ISLAND' => 'NF',
		'NORTHERN MARIANA ISLANDS' => 'MP',
		'NORWAY' => 'NO',
		'OMAN' => 'OM',
		'PALAU' => 'PW',
		'PALESTINE' => 'PS',
		'PANAMA' => 'PA',
		'PARAGUAY' => 'PY',
		'PERU' => 'PE',
		'PHILIPPINES' => 'PH',
		'PITCAIRN' => 'PN',
		'POLAND' => 'PL',
		'PORTUGAL' => 'PT',
		'PUERTO RICO' => 'PR',
		'QATAR' => 'QA',
		'REUNION' => 'RE',
		'ROMANIA' => 'RO',
		'REPUBLIC OF SERBIA' => 'RS',
		'RUSSIAN FEDERATION' => 'RU',
		'RWANDA' => 'RW',
		'SAINT HELENA' => 'SH',
		'SAINT KITTS AND NEVIS' => 'KN',
		'SAINT LUCIA' => 'LC',
		'SAINT PIERRE AND MIQUELON' => 'PM',
		'SAINT VINCENT AND THE GRENADINES' => 'VC',
		'SAMOA' => 'WS',
		'SAN MARINO' => 'SM',
		'SAO TOME AND PRINCIPE' => 'ST',
		'SAUDI ARABIA' => 'SA',
		'SENEGAL' => 'SN',
		'SEYCHELLES' => 'SC',
		'SINGAPORE' => 'SG',
		'SLOVAKIA' => 'SK',
		'SLOVENIA' => 'SI',
		'SOLOMON ISLANDS' => 'SB',
		'SOUTH AFRICA' => 'ZA',
		'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS' => 'GS',
		'SPAIN' => 'ES',
		'SURINAME' => 'SR',
		'SVALBARD AND JAN MAYEN' => 'SJ',
		'SWAZILAND' => 'SZ',
		'SWEDEN' => 'SE',
		'SWITZERLAND' => 'CH',
		'TAIWAN, PROVINCE OF CHINA' => 'TW',
		'TANZANIA, UNITED REPUBLIC OF' => 'TZ',
		'THAILAND' => 'TH',
		'TIMOR-LESTE' => 'TL',
		'TOGO' => 'TG',
		'TOKELAU' => 'TK',
		'TONGA' => 'TO',
		'TRINIDAD AND TOBAGO' => 'TT',
		'TUNISIA' => 'TN',
		'TURKEY' => 'TR',
		'TURKMENISTAN' => 'TM',
		'TURKS AND CAICOS ISLANDS' => 'TC',
		'TUVALU' => 'TV',
		'UGANDA' => 'UG',
		'UKRAINE' => 'UA',
		'UNITED ARAB EMIRATES' => 'AE',
		'UNITED KINGDOM' => 'GB',
		'UNITED STATES' => 'US',
		'UNITED STATES MINOR OUTLYING ISLANDS' => 'UM',
		'URUGUAY' => 'UY',
		'UZBEKISTAN' => 'UZ',
		'VANUATU' => 'VU',
		'VENEZUELA' => 'VE',
		'VIET NAM' => 'VN',
		'VIRGIN ISLANDS, BRITISH' => 'VG',
		'VIRGIN ISLANDS, U.S.' => 'VI',
		'WALLIS AND FUTUNA' => 'WF',
		'WESTERN SAHARA' => 'EH',
		'ZAMBIA' => 'ZM',
	);
	$up = strtoupper($country);
	if (in_array($up, $tab)) {
		return $up;
	}
	if (!isset($tab[$up])) {
		trigger_error('Invalid country: '.$state, E_USER_WARNING);
		return null;
	}
	return $tab[$up];
}
