
<?php
/*****************************************
//
//    home page template for my.Contacts
//    Author: Keran McKenzie
//    Date:   18 Jan 2013
//
//    Provided as sample only, not intended for production
//
*******************************************/
?>
<h1>my.Contacts</h1>
<p>Listed below are the company files found in the directory. Please select which you'd like to work with.</p>
      
<?php
// lets use our function to get the company file list 
$companyFileList = getFileList();

if( isset($companyFileList->Message) ) {
	echo '<p class="alert alert-error"><strong>Sorry</strong> there has been an error.<br />API Message: '.$companyFileList->Message.'</p>';
} else {
	
	// use a foreach to look through the list and spit out each company file
	echo '<!-- lets list the company files in a vertical button group to make it easy to click/select a file -->
<div class="btn-group btn-group-vertical span10" style="padding-bottom: 25px;">';
	foreach ($companyFileList as $companyFile) {
	  // spit out HTML for each company file
	  echo '<a class="btn btn-large btn-block" style="text-align: left; padding-left: 5px; padding-right: 5px;" href="signin/'.$companyFile->Id.'/">'.$companyFile->Name.' </a>';
	}
	echo '</div> <!-- end our vertical button group -->';

}


?>



<div id="push"></div>  <!-- ensure footer is on bototm of page -->
</div> <!-- /container -->
</div>