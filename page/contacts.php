<?php
/*****************************************
//
//    contacts list page template for my.Contacts
//    Author: Keran McKenzie
//    Date:   18 Jan 2013
//
//    Provided as sample only, not intended for production
//      This page uses the $type variable to change its setup
//
*******************************************/

// first up, what type of contacts list are we getting?
$type = $_GET['type'];
$balanceBadge = '';

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
      	<form class="form-search pull-right hidden-phone" style="margin-top: 15px;" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
  			<input type="text" class="input-medium search-query" name="query" />
  			<button type="submit" class="btn">Search</button>
		</form>
		<form class="form-search visible-phone" style="margin-top: 15px;" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
  			<input type="text" class="input-medium search-query" name="query" />
  			<button type="submit" class="btn">Search</button>
		</form>
      	<h2>My <?php echo ucfirst($type); ?>s</h2>
      	<?php 

      	// if there is an error STOP
      	// are we doing a search or simple look up ?
		if ( isset($_POST['query']) ) {
			// we are doing a search
			$contactList = searchContactList($type, $_POST['query']);
			
		} else {
			// we are doing a contactList lookup
			$contactList = getContactList($type);	
		}
		
		// if there is an error STOP
		/*if( !$contactList ) {
			// throw an error and stop
			echo '<p class="alert alert-error"><strong>Sorry</strong> there has been an error.<br />API Message: '. (!$contactList ? 'The api is returning NULL' : $contactList->Message ) .'</p>';
			die();
		}*/
      	?>
      	<!-- we are showing tabular data - so lets setup a table (note this is hidden-phone) -->
      	<table class="table table-bordered table-striped hidden-phone">
			<thead>
			<tr>
				<th></th>
				<th>Name</th>
				<th>State</th>
				<th>Phone</th>
				<?php // don't show balance for employee
				if( $type!='employee' ) {
					echo '<th>Balance</th>';
				}
				?>
			</tr>
			</thead>
			<tbody>
				<?php
				// the page is set, lets get the contacts and loop through and display them

				
				
				// lets loop through them
				foreach ($contactList->Items as $customer) {
					echo '<tr class="contactRow" onclick="document.location = \''.$pageURL.'contact/'.$type.'/'.$customer->Id.'/\';">';
					// show a different icon based on customer type
					if( $customer->IsIndividual ){
						echo '<td style="text-align: center;" class="contactCell"><i class="icon-user"></i></td>';
					} else {
						echo '<td style="text-align: center;" class="contactCell"><i class="icon-briefcase"></i></td>';
					}
    				echo '<td class="contactCell">'.$customer->CoLastName; // last name
    				if( $customer->IsIndividual ) {
    					// show their first name
    					echo ', '.$customer->FirstName; // first name
    				}
    				echo '</td>';
    				//
    				//  NOTE:
    				//  In the account right API there are up to 5 addresses per contact
    				//    these are made available to the API as an array, however for
    				//    the purposes of this demo we'll assume the detail we want is in
    				//    address 1 and so we'll hard code array[0] for now
    				//
    				echo '<td class="contactCell">'.$customer->Addresses[0]->State.'</td>'; // state of primary address
    				echo '<td class="contactCell">'.$customer->Addresses[0]->Phone1.'</td>'; // state of primary address

    				// // lets not show this for the employee
    				if( $type!='employee' ) {
    				// lets get the balance
    				if($customer->CurrentBalance < 0) {
    					// if it's lets than $0 show it as orange - use the bootstrap WARNING label
    					$balanceBadge = 'label-warning';
    				} elseif($customer->CurrentBalance > 0) {
    					// if it's lets than $0 show it as green - use the bootstrap SUCCESS label
    					$balanceBadge = 'label-success';

    				}

    				echo '<td class="contactCell"><span class="label label-large '.$balanceBadge.' pull-right">'.money_format('$%i',$customer->CurrentBalance).'</span></td>'; // first name
    				} // end if employee

    				echo '</tr>';
				}
				?>
			</tbody>
		</table>
		<!-- now lets setup the phone specific view -->
      	<table class="table table-bordered visible-phone">
      		<thead>
			<tr>
				<th>Name</th>
				<th>State</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
				<?php
				
				// lets loop through them
				foreach ($contactList->Items as $customer) {
					// in ARLive Cash Sales is included as a customer contact - lets skip it as it's not really
					if (!($customer->CoLastName != 'Cash Sales')) { 
        				continue;
    				}

					echo '<tr class="iPhoneContact" style="cursor: pointer;" onclick="document.location = \''.$pageURL.'contact/'.$type.'/'.$customer->Id.'/\';">';
    				// they will all have a lastname (or company name)
    				echo '<td style="border-bottom: none; border-right: none;"><strong>'.$customer->CoLastName;
    				// if they are an individual they'll also have a first name
    				if( ($customer->IsIndividual) && (isset($customer->FirstName)) ){
    					echo ', '.$customer->FirstName;
    				}

    				echo '</strong></td>'; // close the cell
    				
    				echo '<td style="border-left: none; border-right: none;">'.$customer->Addresses[0]->State.'</span></td>'; // phone number

    				// we want the user to know they can click this - so put an ARROW in the cell
    				echo '<td rowspan="2" style="text-align: center; border-left: none;" class="contactCell"><a class="btn btn-primary" href="'.$pageURL.'contact/'.$type.'/'.$customer->Id.'/"><i class="icon-chevron-right icon-white"></i></a></td>';
    				echo '</tr>';
    				echo '<tr><td colspan="2"  style="border-top: none; border-right: none; padding-top: 0px;"><span class="btn btn-mini">'.str_replace(' ', '&nbsp;', $customer->Addresses[0]->Phone1).'</span>';
    				// // lets not show this for the employee
    				if( $type!='employee' ) {
    				// lets get the balance
    				if($customer->CurrentBalance < 0) {
    					// if it's lets than $0 show it as orange - use the bootstrap WARNING label
    					$balanceBadge = 'label-warning';
    				} elseif($customer->CurrentBalance > 0) {
    					// if it's lets than $0 show it as green - use the bootstrap SUCCESS label
    					$balanceBadge = 'label-success';
    				}
    				echo '<div class="pull-right">Balance: <span class="label label-large '.$balanceBadge.'">'.money_format('$%i',$customer->CurrentBalance).'</span></div>';
    				} // end if employee
    				echo '</td></tr>';
    				
				}
				?>
			</tbody>
		</table>

	</div> <!-- end row-fluid -->
</div> <!-- end container-fluid -->

<!-- clean up divs -->
</div> 

<div id="push"></div> <!-- ensure footer is on bototm of page -->
</div> <!-- /container -->
</div>