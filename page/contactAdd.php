<?php
/*****************************************
//
//    add a contact page template for my.Contacts
//    Author: Keran McKenzie
//    Date:   20 Jan 2013
//
//    Provided as sample only, not intended for production
//      This page uses the $type variable to change its setup
//
*******************************************/

// first up, what type of contacts list are we getting?
$type = '';//$_GET['type'];

require_once('header.php');

// do we have form content to submit
if( isset($_POST['inputCoLastName']) ) {
	// save the contact
	// type, ID, lastname, firstname, isactive, taxcodeid, freighttaxcodeid
	$save = saveContact($_POST['type'], '', $_POST['inputCoLastName'], $_POST['inputFirstName'], 'True', 'GST', 'GST');
	
	?>
	<div class="alert alert-success">
	  <p><strong>Saved</strong> contact to AccountRight</p>
	  <p><a class="btn btn-primary btn-large" href="<?php echo $pageURL.$_POST['type']; ?>s/">Return to the <?php echo $_POST['type']; ?> list</a>
	</div>
	<?php
} else {
?>
<!-- setup a 2 col responsive page -->
<div class="container-fluid">
	<div class="span12">
      	<!--Body content-->
      	<h2>Add a new contact</h2>
      	<form class="span5" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
		  <fieldset>
		    <legend>Contact Type</legend>
		    <label>Select a contact type</label>
		    <select class="span5" name="type">
			  <option value="customer" <?php echo (($type == 'customer') ? 'selected' : '') ?>>Customer</option>
			  <option value="supplier" <?php echo (($type == 'supplier') ? 'selected' : '') ?>>Supplier</option>
			  <option value="employee" <?php echo (($type == 'employee') ? 'selected' : '') ?>>Employee</option>
			</select>
			<legend>Contact Details</legend>
			<div class="control-group ">
			    <label class="control-label hidden-phone" for="inputCoLastName">Company or Last Name</label>
			    <div class="controls">
			      <input type="text" id="inputCoLastName" name="inputCoLastName" placeholder="Company or Last Name" class="span5" required>
			    </div>
			</div>
			<div class="control-group ">
			    <label class="control-label hidden-phone" for="inputFirstName">First Name</label>
			    <div class="controls">
			      <input type="text" id="inputFirstName" name="inputFirstName" placeholder="First Name" class="span5">
			    </div>
			</div>
			<div class="form-actions">
			  <button type="submit" class="btn btn-primary"><i class="icon-file icon-white"></i> Save contact</button>
			  <button type="button" class="btn" onClick="history.back()"><i class="icon-remove"></i> Cancel</button>
			</div>
		  </fieldset>
		</form>
    </div><!-- end the span12 -->
</div> <!-- end container-fluid -->

<!-- clean up divs -->
</div> 

<div id="push"></div> <!-- ensure footer is on bototm of page -->
</div> <!-- /container -->
</div>
<?php
} // end the if
?>
