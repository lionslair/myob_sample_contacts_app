<?php
/*****************************************
//
//    base page for my.Contacts
//    Author: Keran McKenzie
//    Date:   18 Jan 2013
//
//    Provided as sample only, not intended for production
//    Basic page layout Twitter Bootstrap http://twitter.github.com/bootstrap/examples/starter-template.html
//
//    Makes use of:
//       Bootstrap from Twitter: http://twitter.github.com/bootstrap/
//       jQuery: http://www.jquery.com
//
//    Copyright (2013) MYOB Technology 
//
*******************************************/
error_reporting(0);
// we'll be using session variables to track some details so lets fire up our session before anything else happens
session_start();

// load up our default vars & functions
include_once('scripts/variables.php');
include_once('scripts/functions.php');




// what are we doing here
// use a SWITCH to do manage rudimentary routing
$page = '';
if(isset($_GET['page'])) { $page = $_GET['page']; } else { $page = Null; }

// is the userlogged in? if not redirect to home page
if( ($page != 'signin') && !isset($_SESSION['username']) ) {
  $page = null;
}

switch($page) {
  case "signin": // this handles the user signin to a specific company file
      // get the page
      require_once('page/signin.php');
      // get the footer
      require_once('footer.php');
        break;

    case "contacts": // get a list of all the customers
        // get the page
        require_once('page/contacts.php');
        // get the footer
        require_once('footer.php');
        break;
    case "contact": // get a singular contact

        // our .htaccess file is passing us two variables from the url
        $type = $_GET['type'];
        $id = $_GET['id'];

        // get the page
        require_once('page/contact.php');
        // get the footer
        require_once('footer.php');
        break;
    case "edit": // we're going to edit a record

        // our .htaccess file is passing us two variables from the url
        $type = $_GET['type'];
        $id = $_GET['id'];

        // get the page
        require_once('page/contactEdit.php');
        // get the footer
        //require_once('footer.php');
        break;
    case "add": // we're going to add a record

        // get the page
        require_once('page/contactAdd.php');
        // get the footer
        require_once('footer.php');
        break;

    default: // this is the fault page that loads up and lists the company files found in the director
       
      // get the header
      require_once('header.php');
      // get the page
      require_once('page/home.php');
      // get the footer
      require_once('footer.php');
}