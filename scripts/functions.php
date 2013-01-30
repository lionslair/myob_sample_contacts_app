<?php

/*****************************************
//
//    Generic Functions for my.Contacts
//    Author: Keran McKenzie
//    Date:   18 Jan 2013
//
*******************************************/


/**
 * Function Name: getURL
 * 
 * This function is an example of calling a URL with optional
 *   username and password for basic header authentication
 *   
 * Supplied as an example only, not intended for production code
 *
 * Expects: 
 *   $url (string) a url to the api you want to call
 *   $username (string) (optional) the username for authentication
 *   $password (string) (optional) the password for authentication
 *
 * Returns:
 *   json encoded response
 *
 * TODO:
 *   Add error checking on response
 */
function getURL($url, $username=NULL, $password=NULL) {
	
	// setup the session & setup curl options
	$session = curl_init($url); 
	curl_setopt($session, CURLOPT_HEADER, true); 
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
	
	// if there is a username present, assume we want to use it
	if($username) {
		// pass the username and password like 'username:password' to curl
		curl_setopt($session, CURLOPT_USERPWD, $username . ":" . $password);
	} 
	
	// get the response & close the session
	$response = curl_exec($session); 
	curl_close($session); 
	
	// return what we got
	return($response);
}


/**
 * Function Name: getFileList
 * 
 * This function is an example of calling a the base URL
 *   which will return a list of all the MYOB ARLive company files
 *   
 * Supplied as an example only, not intended for production code
 *
 * Expects: 
 *   nothing
 *
 * Returns:
 *    json decoded list of company files
 *
 * TODO:
 *   Add error checking on response
 */
function getFileList() {
	global $apiBaseURL; // bad practice in production - fine for this example

	// use the getURL function to call the URL
	$response = getURL($apiBaseURL);

	// it returned as JSON so lets decode it
	$response = json_decode($response);

	// return the response
	return($response);
}

/**
 * Function Name: doLogin
 * 
 * This function is an example of calling a URL with authentication
 *    it doesn't really do the login, it checks that the username & password let
 *    the user request a generic URL
 *   
 * Supplied as an example only, not intended for production code
 *
 * Expects: 
 *   nothing
 *
 * Returns:
 *    TRUE or FALSE
 */
function doLogin($username, $password) {
	global $apiBaseURL; // bad practice in production - fine for this example

	// use the getURL function to call the URL - remember we are calling the companyFileGUID from the session vars
	$response = getURL($apiBaseURL.$_SESSION['companyFileGUID'].'/', $username, $password);

	// it returned as JSON so lets decode it
	$response = json_decode($response);

	// now given the API doens't have an explicit login function lets check the credentails
	if(@$response->Message === 'Access denied') {
		// failed
		return(FALSE);
	} else {
		// passed
		return(TRUE);
	}

	
}


/**
 * Function Name: getContactList
 * 
 * This function is an example of calling fetching the contact lists from ARLive
 *    it will pull from the 3 different types & returns their responses
 *   
 * Supplied as an example only, not intended for production code
 *
 * Expects: 
 *   $type (string) - this tells us if it's a Customer, Supplier or Employee
 *
 * Returns:
 *    json_decoded response from API
 *
 * TODO:
 *   Add error checking on response
 */
function getContactList($type) {
	global $apiBaseURL; // bad practice in production - fine for this example

	// the URL expects the type to have a capital first letter - lets force this
	$type = ucfirst($type);

	// use the getURL function to call the URL - remember we are calling the vars we need from the session vars
	$response = getURL($apiBaseURL.$_SESSION['companyFileGUID'].'/'.$type.'/', $_SESSION['username'], $_SESSION['password']);

	// it returned as JSON so lets decode it
	$response = json_decode($response);
	
	// return the response
	return($response);
	
}

/**
 * Function Name: getContact
 * 
 * This function is an example of calling fetching a specific contact from ARLive
 *    it will pull from the 3 different types & returns their responses
 *   
 * Supplied as an example only, not intended for production code
 *
 * Expects: 
 *   $type (string) - this tells us if it's a Customer, Supplier or Employee
 *   $contact Id (string) - this is the customer ID from ARLive
 *
 * Returns:
 *    json_decoded response from API
 *
 * TODO:
 *   Add error checking on response
 */
function getContact($type, $contactId) {
	global $apiBaseURL; // bad practice in production - fine for this example

	// the URL expects the type to have a capital first letter - lets force this
	$type = ucfirst($type);

	// use the getURL function to call the URL - remember we are calling the vars we need from the session vars
	$response = getURL($apiBaseURL.$_SESSION['companyFileGUID'].'/'.$type.'/'.$contactId, $_SESSION['username'], $_SESSION['password']);

	// it returned as JSON so lets decode it
	$response = json_decode($response);
	
	// return the response
	return($response);
	
}

/**
 * Function Name: saveContact
 * 
 * This function is an example of POSTING to a URL with to save data
 *    for this example we only save/update a select few iterms
 *   
 * Supplied as an example only, not intended for production code
 *
 * Expects: 
 *   $url (string) a url to the api you want to call
 *   $username (string) (optional) the username for authentication
 *   $password (string) (optional) the password for authentication
 *
 * Returns:
 *   json encoded response
 *
 * TODO:
 *   Add error checking on response
 */
function saveContact($type, $contactId, $CoLastName, $FirstName, $IsActive, $TaxCodeId, $FreightTaxCodeId) {
	global $apiBaseURL;


	// Lets setup the url we want to post to
    $url =  $apiBaseURL.$_SESSION['companyFileGUID'].'/'.$type.'/'.$contactId;
    
    // urlencode parameters & add to url
    $params = 'CoLastName='.urlencode($CoLastName).'&FirstName='.urlencode($FirstName).'&IsActive='.urlencode($IsActive).'&TaxCodeId='.urlencode($TaxCodeId).'&FreightTaxCodeId='.urlencode($FreightTaxCodeId);

    $session = curl_init($url); 

    // Tell curl to use HTTP POST
    curl_setopt ($session, CURLOPT_POST, true); 
    // Tell curl that this is the body of the POST
    curl_setopt ($session, CURLOPT_POSTFIELDS, $params); 
    // setup the authentication
    curl_setopt($session, CURLOPT_USERPWD, $_SESSION['username'] . ":" . $_SESSION['password']);
    // Tell curl not to return headers, but do return the response
    curl_setopt($session, CURLOPT_HEADER, false); 
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);



    $response = curl_exec($session); 
  	curl_close($session);

  	return($response);
}

/**
 * Function Name: searchContactList
 * 
 * This function is an example of searching the contact lists from ARLive
 *    it will search based on type & returns their responses
 *   
 * Supplied as an example only, not intended for production code
 *
 * Expects: 
 *   $type (string) - this tells us if it's a Customer, Supplier or Employee
 *   $query (string) - this is what the user searched for
 *
 * Returns:
 *    json_decoded response from API
 *
 * TODO:
 *   Add error checking on response
 */
function searchContactList($type, $query) {
	global $apiBaseURL; // bad practice in production - fine for this example

	// the URL expects the type to have a capital first letter - lets force this
	$type = ucfirst($type);

	// lets lowercase and strip white space (really you should do more cleaning up of user input)
	$query = trim(strtolower($query));

	//
	//  To do a search we are using the $filter from the oData specification
	//      http://www.odata.org/documentation/uri-conventions#FilterSystemQueryOption
	//  We search only the CoLastName and FirstName for this example
	//

	$filter = "filter=substringof('".$query."',%20CoLastName)%20or%20substringof('".$query."',%20FirstName)%20eq%20true";


	// use the getURL function to call the URL - remember we are calling the vars we need from the session vars
	$response = getURL($apiBaseURL.$_SESSION['companyFileGUID'].'/'.$type.'/?$'.$filter, $_SESSION['username'], $_SESSION['password']);

	// it returned as JSON so lets decode it
	$response = json_decode($response);
	// return the response
	return($response);
	
}