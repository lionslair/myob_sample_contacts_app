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

require_once('header.php');
?>
<!-- setup a 2 col responsive page -->
<div class="container-fluid">
	<div class="row-fluid">

	<!-- setup our sidebar -->
	<div class="span2">
		<h2>Type</h2>
			<?php // little script to set the btn-primary on the current page
				switch($type) {
					case "customer":
						$customerBtn = ' btn-primary';
					break;
					case "supplier":
						$supplierBtn = ' btn-primary';
					break;
					case "employee":
						$employeeBtn = ' btn-primary';
					break;
				}
			?>
			<a class="btn btn-large btn-block <?php echo $customerBtn; ?>" href="<?php echo $pageURL; ?>customers/">Customers</a>
			<a class="btn btn-large btn-block <?php echo $supplierBtn; ?>" href="<?php echo $pageURL; ?>suppliers/">Suppliers</a>
			<a class="btn btn-large btn-block <?php echo $employeeBtn; ?>" href="<?php echo $pageURL; ?>employees/">Employees</a>
	</div>

	<!-- setup our main body -->
	<div class="span10">
      	<!--Body content-->
      	<form class="form-search pull-right" style="margin-top: 15px;" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
  			<input type="text" class="input-medium search-query" name="query" />
  			<button type="submit" class="btn">Search</button>
		</form>
      	<h2>My <?php echo ucfirst($type); ?>s</h2>
      	<!-- we are showing tabular data - so lets setup a table -->
      	<table class="table table-bordered table-striped">
			<thead>
			<tr>
				<th>Last Name</th>
				<?php // don't show First Name for suppliers
				if( $type!='supplier' ) {
					echo '<th>First Name</th>';
				}
				?>
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

				// are we doing a search or simple look up ?
				if ( isset($_POST['query']) ) {
					// we are doing a search
					$contactList = searchContactList($type, $_POST['query']);
					
				} else {
					// we are doing a contactList lookup
					$contactList = getContactList($type);	
				}
				
				// lets loop through them
				foreach ($contactList->Items as $customer) {
					echo '<tr style="cursor: pointer;" onclick="document.location = \''.$pageURL.'contact/'.$type.'/'.$customer->Id.'/\';">';
    				echo '<td>'.$customer->CoLastName.'</td>'; // last name
    				if( $type!='supplier' ) {
    					echo '<td>'.$customer->FirstName.'</td>'; // first name
    				}
    				//
    				//  NOTE:
    				//  In the account right API there are up to 5 addresses per contact
    				//    these are made available to the API as an array, however for
    				//    the purposes of this demo we'll assume the detail we want is in
    				//    address 1 and so we'll hard code array[0] for now
    				//
    				echo '<td>'.$customer->Addresses[0]->State.'</td>'; // state of primary address
    				echo '<td>'.$customer->Addresses[0]->Phone1.'</td>'; // state of primary address

    				// // lets not show this for the employee
    				if( $type!='employee' ) {
    				// lets get the balance
    				$balanceBadge = '';
    				if($customer->CurrentBalance < 0) {
    					// if it's lets than $0 show it as orange - use the bootstrap WARNING label
    					$balanceBadge = 'label-warning';
    				} elseif($customer->CurrentBalance > 0) {
    					// if it's lets than $0 show it as green - use the bootstrap SUCCESS label
    					$balanceBadge = 'label-success';

    				}

    				echo '<td ><span class="label label-large '.$balanceBadge.' pull-right">'.money_format('$%i',$customer->CurrentBalance).'</span></td>'; // first name
    				} // end if employee

    				echo '</tr>';
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