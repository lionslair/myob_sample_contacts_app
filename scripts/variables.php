<?php
/*****************************************
//
//    Generic Variables for my.Contacts
//    Author: Keran McKenzie
//    Date:   18 Jan 2013
//
*******************************************/

// quick SWITCH for setting vars when in localhost vs production
switch($_SERVER['SERVER_NAME']) {
	case "localhost":
		// dev api details
		$apiBaseURL   = "http://localhost:8080/AccountRight/";
		$apiKey       = ""; // not used in this sample
		$apiSecret    = ""; // not used in this sample

		// dev page vars
		$pageURL      = "http://localhost/AccountRight_ContactSample_PHP/"; // URL to your PHP environment - I use MAMP that has 8888 as port
	break;
	case "account-right.lionslair.net.au":
		// dev api details
		$apiBaseURL   = "https://api.myob.com/accountright/";
		$apiKey       = "9yg8gjumbww5j7yrfxk83ypz"; // not used in this sample
		$apiSecret    = "6b5EM7w8yuxrGNGZVJ4DDCbP"; // not used in this sample

		// dev page vars
		$pageURL      = "http://account-right.lionslair.net.au/"; // URL to your PHP environment - I use MAMP that has 8888 as port
	break;
	default:
		// production api details
		$apiBaseURL   = "<!-- CLOUD API URL HERE -->";
		$apiKey       = ""; // not used in this sample
		$apiSecret    = ""; // not used in this sample

		// dev page vars
		$pageURL      = "http://www.yourwebdomain.com"; // put your URL here
	break;
}

$debug = false;

// navigation vars
$customerBtn = '';
$customerIcon = '';
$supplierBtn = '';
$supplierIcon = '';
$employeeBtn = '';
$employeeIcon = '';

// map options
$showMap = false;
$googleAPIKey = '<!-- PUT A GOOGLE PLACES API KEY HERE -->';
