<?php 
// header file
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>my.Contacts</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <link rel="apple-touch-icon" href="iphone/icon.png"/>
    <link rel="apple-touch-startup-image" href="iphone/startup.png">

    <!-- Le styles -->
    <link href="<?php echo($pageURL); ?>css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo($pageURL); ?>css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <style type="text/css">

      /* Sticky footer styles
      -------------------------------------------------- */

      html,
      body {
        height: 100%;
        /* The html and body elements cannot have any padding or margin. */
      }

      /* Wrapper for page content to push down footer */
      #wrap {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
        min-height: 100%;
        height: auto !important;
        
        /* Negative indent footer by it's height */
        margin: -60px auto -60px;
      }

      #mainBody {
        padding-top: 60px; /* offset the header */
      }

      @media (max-width: 979px) { 
          #mainBody {
            padding-top: 0px; /* offset the header */
          }
      }

      /* Set the fixed height of the footer here */
      #push,
      #footer {
        height: 60px;
      }
      #footer {
        background-color: #f5f5f5;
      }

      #footer .container {
        padding-top: 20px;
      }

      /* Lastly, apply responsive CSS fixes as necessary */
      @media (max-width: 767px) {
        #footer {
          margin-left: -20px;
          margin-right: -20px;
          padding-left: 20px;
          padding-right: 20px;
        }
      }

      .contactRow {
        cursor: pointer 
      }

      .contactRow:hover, .contactRow:hover td.contactCell {
        background-color: #dff0d8; !important
      }

      tr.iPhoneContact td {
        vertical-align:middle;
      }

    </style>

  <script src="http://code.jquery.com/jquery-latest.js"></script>

<?php // custom code for google maps 
if( isset($showMap) ) {
?>
  <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=<?php echo $googleAPIKey; ?>&sensor=true">
    </script>
    <script type="text/javascript">
      var geocoder;
      var map;
      function initialize() {
        geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(-34.397, 150.644);
        var mapOptions = {
          zoom: 16,
          center: latlng,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

        codeAddress();

        // set the height of the map box to match the width
        $('#map_canvas').height($('#map_canvas').width());
      }

      function codeAddress() {
        var address = '<?php echo $theAddress; ?>';
        geocoder.geocode( { 'address': address}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
                map: map,
                position: results[0].geometry.location
            });
          } else {
            alert("Geocode was not successful for the following reason: " + status);
          }
        });

        //alert('The address is: <?php echo $theAddress; ?>');
      }


    </script>
  </head>
  <body onload="initialize()">
  <?php
  } else {
  ?>
  </head>
  <body>
<?php
}
?>
    <div id="wrap">
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="<?php echo($pageURL); ?>">my.Contacts</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="<?php echo($pageURL); ?>">Home</a></li>
              <li class="hidden"><a href="#about">About</a></li>
              <li class="hidden"><a href="#contact">Contact</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container" id="mainBody">
<!-- HEADER -->