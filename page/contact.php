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

// lets get our contact
$contact = getContact($type, $id);

$theAddress = $contact->Addresses[0]->Street .', '.$contact->Addresses[0]->City .', '. $contact->Addresses[0]->State .', '.$contact->Addresses[0]->PostCode .', '.$contact->Addresses[0]->Country;

$showMap = true;
require_once('header.php');
?>
<!-- setup a 2 col responsive page -->
<div class="container-fluid">
	<div class="row-fluid">

	<!-- setup our sidebar -->
	<div class="span2">
		<div class="hidden-phone">
		<h2>Type</h2><!-- main screens -->
			<?php // little script to set the btn-primary on the current page
				switch($type) {
					case "customer":
						$customerBtn = ' btn-primary';
						$customerIcon = ' icon-white';
					break;
					case "supplier":
						$supplierBtn = ' btn-primary';
						$supplierIcon = ' icon-white';
					break;
					case "employee":
						$employeeBtn = ' btn-primary';
						$employeeIcon = ' icon-white';
					break;
				}
			?>
			<a class="btn btn-large btn-block <?php echo $customerBtn; ?>" href="<?php echo $pageURL; ?>customers/"><i class="icon-heart <?php echo $customerIcon; ?>"></i> Customers</a>
			<a class="btn btn-large btn-block <?php echo $supplierBtn; ?>" href="<?php echo $pageURL; ?>suppliers/"><i class="icon-shopping-cart <?php echo $supplierIcon; ?>"></i> Suppliers</a>
			<a class="btn btn-large btn-block <?php echo $employeeBtn; ?>" href="<?php echo $pageURL; ?>employees/"><i class="icon-user <?php echo $employeeIcon; ?>"></i> Employees</a>
			<a class="btn btn-large btn-block btn-success" href="<?php echo $pageURL; ?>add/"><i class="icon-plus-sign icon-white"></i> Add New</a>
		</div>

		<div class="visible-phone btn-group"> 
			<h4>Type</h4><!-- iphone version -->
			<a class="btn <?php echo $customerBtn; ?> btn-large" href="<?php echo $pageURL; ?>customers/"><i class="icon-heart <?php echo $customerIcon; ?>"></i></a>
			<a class="btn <?php echo $supplierBtn; ?> btn-large" href="<?php echo $pageURL; ?>suppliers/"><i class="icon-shopping-cart <?php echo $supplierIcon; ?>"></i></a>
			<a class="btn <?php echo $employeeBtn; ?> btn-large" href="<?php echo $pageURL; ?>employees/"><i class="icon-user <?php echo $employeeIcon; ?>"></i></a>
			<a class="btn btn-success btn-large" href="<?php echo $pageURL; ?>add/"><i class="icon-plus-sign icon-white"></i></a>
		</div>
	</div>

	<!-- setup our main body -->
	<div class="span10">
      	<!--Body content-->
      	<div class="span10">
      		<h2>
      			<?php
      			// is this a company or an individual
      			if( $contact->IsIndividual ){
      				// its a person so display first then last name
      				echo $contact->FirstName .' '. $contact->CoLastName;
      				$name = $contact->FirstName .' '. $contact->CoLastName;
      			} else {
      				// it's a company so display last name
      				echo $contact->CoLastName;
      				$name = $contact->CoLastName;
      			}

      			// is this contact active or not?
      			if( $contact->IsActive ) {
      				// yes they are active - this is repeated below for iPhone
      				echo '<span class="btn btn-success pull-right hidden-phone"><i class="icon-ok icon-white"></i>&nbsp;Active</span>';
      			} else {
      				// no they are not active
      				echo '<span class="btn btn-danger pull-right" hidden-phone><i class="icon-remove icon-white"></i>&nbsp;Not Active</span>';
      			}
      			?>
      		</h2>
      	</div>
      	<div class="span4">
      		<address class="large">
      		  <?php // move the active stuff here for iPhone 
      		  // is this contact active or not?
      			if( $contact->IsActive ) {
      				// repeat the isActive stuff here
      				echo '<span class="btn btn-success pull-right visible-phone"><i class="icon-ok icon-white"></i></span>';
      			} else {
      				// no they are not active
      				echo '<span class="btn btn-success pull-right visible-phone"><i class="icon-remove icon-white"></i></span>';
      			}
      		  ?>
			  <?php echo $contact->Addresses[0]->Street; ?><br />
			  <?php echo $contact->Addresses[0]->City; ?>, <?php echo $contact->Addresses[0]->State; ?>, <?php echo $contact->Addresses[0]->PostCode; ?><br />
			  <abbr title="Phone">P:</abbr> <?php echo $contact->Addresses[0]->Phone1; ?><br />
			  <abbr title="Email">E:</abbr> <a href="mailto:<?php echo $contact->Addresses[0]->Email; ?>"><?php echo $contact->Addresses[0]->Email; ?></a><br />
			  <a class="btn btn-primary btn-mini" style="margin-top: 10px;" href="http://maps.apple.com/?q=<?php echo $theAddress; ?>"><i class="icon-map-marker icon-white"></i> Get directions</a>
			</address>

			<blockquote>
  				<p><?php // the description often contains * so lets do a basic clean up
  				echo(str_replace('*', '<br />&bull; ', $contact->Description)); ?></p>
			</blockquote>

			<!-- lets add a QR code so people can scan the business details to their phone but hide it from iPhone -->
		<div class="hidden-phone">
			<img class="img-polaroid " style="width:140px; height:140px;" src="http://chart.apis.google.com/chart?cht=qr&amp;chs=150x150&amp;chl=Name: <?php echo $name ?> Address: <?php echo $theAddress; ?> Phone: <?php echo $contact->Addresses[0]->Phone1; ?>&amp;chld=l|0" alt="QRCode" />
			<p class="small muted">Scan with your phone and save to contacts</p>
		</div>

		</div>
		<div class="span6">
			<div id="map_canvas" class="span11 img-polaroid" style="margin-bottom: 20px;"></div>
		</div>


	</div> <!-- end row-fluid -->
</div> <!-- end container-fluid -->

<!-- clean up divs -->
</div> 

<div id="push"></div> <!-- ensure footer is on bototm of page -->
</div> <!-- /container -->
</div>