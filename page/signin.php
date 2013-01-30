<?php
/*****************************************
//
//    signin page template for my.Contacts
//    Author: Keran McKenzie
//    Date:   18 Jan 2013
//
//    Provided as sample only, not intended for production
//      This page manages the signin process
//      In production you wouldn't handle it this way
//
*******************************************/

// do we have form data?
if(isset($_POST['username'])) {
  // yes, so lets process it

  // first up doLogin (in production always clean up what's posted in the form!! - never submit user supplied data raw!)
  if(doLogin($_POST['username'], $_POST['password'])) {
    // login worked - lets now push the user through to the customer details 

    // first lets write the username & password to session vars as we'll need them again in the future
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['password'] = $_POST['password'];

    // lets make sure we RIGHT the session so Chrome behaves nicely
    session_write_close();

    // lets move the user on now
    header('Location: ' . $pageURL.'customers/');
    exit(); // stop anything else running - probably redundant really
  } else {
    // login failed - reload the form (in production don't stick the form in twice - write better code ;) he he he)
    $_SESSION['username'] = '';
    $_SESSION['password'] = '';

    // lets make sure we RIGHT the session so Chrome behaves nicely
    session_write_close();
    
    // get the header
    require_once('header.php');
    ?>
    <form class="form-signin" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
      <h2 class="form-signin-heading">Please sign in</h2>
      <p  class="alert alert-error"><i class="icon-exclamation-sign"></i> <strong>Sorry</strong>, please try again</p>
      <input type="text" class="input-block-level" placeholder="Username" name="username" />
      <input type="password" class="input-block-level" placeholder="Password" name="password" />
      <button class="btn btn-large btn-primary" type="submit">Sign in</button>
    </form>
    <?php
  }
} else {
  // no, so lets display the form
  
  // first up, lets get the company file ID from the URL and write it into a
  //    session variable so we don't have to worry about it again   
  if(!isset($_SESSION['companyFileGUID'])) {
    // not set so lets put it in there
    $_SESSION['companyFileGUID'] = $_GET['guid'];
  }
// get the header
require_once('header.php');
?>
<form class="form-signin" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
  <h2 class="form-signin-heading">Please sign in</h2>
  <p>Enter your username and password</p>
  <input type="text" class="input-block-level" placeholder="Username" name="username" />
  <input type="password" class="input-block-level" placeholder="Password" name="password" />
  <button class="btn btn-large btn-primary" type="submit">Sign in</button>
</form>

<?php
}
?>
<!-- custom form specific CSS - TODO: put in the CSS files -->
<style type="text/css">
  .form-signin {
    max-width: 300px;
    padding: 19px 29px 29px;
    margin: 0 auto 20px;
    background-color: #fff;
    border: 1px solid #e5e5e5;
    -webkit-border-radius: 5px;
       -moz-border-radius: 5px;
            border-radius: 5px;
    -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
       -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
            box-shadow: 0 1px 2px rgba(0,0,0,.05);
  }
  .form-signin .form-signin-heading,
  .form-signin .checkbox {
    margin-bottom: 10px;
  }
  .form-signin input[type="text"],
  .form-signin input[type="password"] {
    font-size: 16px;
    height: auto;
    margin-bottom: 15px;
    padding: 7px 9px;
  }

</style>


<div id="push"></div> <!-- ensure footer is on bototm of page -->
</div> <!-- /container -->
</div>