<?php
/*****************************************
//
//    Show the contact details page template for my.Contacts
//    Author: Keran McKenzie
//    Date:   19 Jan 2013
//
//    Provided as sample only, not intended for production
//      This page uses the $type variable to change its setup
//
*******************************************/

//
// with this page we want to pull the contact details before we build the page
// as we are going to use Google Maps & we load the maps javascript in the header of the page
// we need pull and process the data before loading the header
//

// lets just fudge it

$test = saveContact($type, $id, 'KeranTest', 'TestKeran', 'False', 'GST', 'GST');

print_r($test);