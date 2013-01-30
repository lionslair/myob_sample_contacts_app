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
		$apiBaseURL   = "http://localhost:8080/WebAPI//";
		$apiKey       = ""; // not used in this sample
		$apiSecret    = ""; // not used in this sample

		// dev page vars
		$pageURL      = "http://localhost:8888/mycontacts/"; // URL to your PHP environment - I use MAMP that has 8888 as port
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

$googleAPIKey = '<!-- PUT A GOOGLE PLACES API KEY HERE -->';