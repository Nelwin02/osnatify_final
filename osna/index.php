<!DOCTYPE html>
<html lang="en">
   <!-- Basic -->
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <!-- Mobile Metas -->
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="viewport" content="initial-scale=1, maximum-scale=1">
   <!-- Site Metas -->
   <title>OSNA</title>
   <meta name="keywords" content="">
   <meta name="description" content="">
   <meta name="author" content="">
   <!-- Site Icons -->
   <link rel="shortcut icon" href="images/opd.png" type="image/x-icon" />
   <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="css/bootstrap.min.css">
   <!-- Site CSS -->
   <link rel="stylesheet" href="style.css">
   <!-- Colors CSS -->
   <link rel="stylesheet" href="css/colors.css">
   <!-- ALL VERSION CSS -->
   <link rel="stylesheet" href="css/versions.css">
   <!-- Responsive CSS -->
   <link rel="stylesheet" href="css/responsive.css">
   <!-- Custom CSS -->
   <link rel="stylesheet" href="css/custom.css">
   <!-- Modernizer for Portfolio -->
   <script src="js/modernizer.js"></script>
   <!-- [if lt IE 9] -->
   </head>
   <body class="clinic_version">
      <!-- LOADER -->
      <div id="preloader">
         <img class="preloader" src="images/loaders/heart-loading2.gif" alt="">
      </div>
      <!-- END LOADER -->
      <header>
      <?php
include 'db.php'; 

$image = ''; 

// Updated SQL query using PostgreSQL's pg_query
$sql = "SELECT image_path FROM admin_settings";
$result = pg_query($con, $sql);

if ($result) {
    $user = pg_fetch_assoc($result);
    if ($user) {
        $image = '../admin/Images/' . basename($user['image_path']);
    }
}

?>

<div class="header-top wow fadeIn">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="<?php echo htmlspecialchars($image); ?>" alt="Website Logo" width="100px" height="100px">
        </a>

        <div class="right-header">
            <div class="header-info">

                <?php

                // Using PDO for PostgreSQL connection
                try {
                    // Prepare and execute the SQL query using PostgreSQL
                    $stmt = pg_prepare($con, "get_admin_settings", "SELECT phone_number, email, opening_time, closing_time FROM admin_settings WHERE id = 1");
                    $result = pg_execute($con, "get_admin_settings", array());

                    if ($result) {
                        $row = pg_fetch_assoc($result);
                        $phone_number = $row['phone_number'] ?? 'No phone number set';
                        $email = $row['email'] ?? 'No email set';
                        $opening_time = $row['opening_time'] ?? '08:00:00';
                        $closing_time = $row['closing_time'] ?? '20:00:00';
                    } else {
                        $phone_number = 'No phone number found';
                        $email = 'No email found';
                        $opening_time = '08:00:00';
                        $closing_time = '20:00:00';
                    }
                } catch (Exception $e) {
                    $phone_number = "Error: " . $e->getMessage();
                    $email = "Error: " . $e->getMessage();
                    $opening_time = 'Error';
                    $closing_time = 'Error';
                }
                ?>
        <div class="info-inner">
            <a href="mailto:<?php echo htmlspecialchars($email); ?>" target="_blank" rel="noopener noreferrer">
                <span class="icontop"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                <span class="iconcont"><?php echo htmlspecialchars($email); ?></span>
            </a>
        </div>


        <div class="info-inner">
            <span class="icontop"><img src="images/phone-icon.png" alt="Phone Icon"></span>
            <span class="iconcont">
                <a href="tel:<?php echo htmlspecialchars($phone_number); ?>"><?php echo htmlspecialchars($phone_number); ?></a>
            </span>  
        </div>


        <div class="info-inner">
            <span class="icontop"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
            <span class="iconcont">
                <a data-scroll href="#">Daily: <?php echo htmlspecialchars(date('g:ia', strtotime($opening_time))) . ' - ' . htmlspecialchars(date('g:ia', strtotime($closing_time))); ?></a>
            </span>  
        </div>
     </div>
</div>
     </div>
         </div>
         <div class="header-bottom wow fadeIn">
            <div class="container">
               <nav class="main-menu">
                  <div class="navbar-header">
                     <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"><i class="fa fa-bars" aria-hidden="true"></i></button>
                  </div>
				  
                  <div id="navbar" class="navbar-collapse collapse">
                     <ul class="nav navbar-nav">
                        <li><a class="active" href="index.php">Home</a></li>
                        <li><a data-scroll href="#about">About us</a></li>
                        
                        <li><a data-scroll href="#doctors">OPD Clerk</a></li>
                        
						
                        <li><a data-scroll href="#getintouch">Contact</a></li>
                        <li><a data-scroll href="#login">Login</a></li>
                     </ul>
                  </div>
               </nav>
               <div class="serch-bar">
                  <div id="custom-search-input">
                     <div class="input-group col-md-12">
                        <input type="text" class="form-control input-lg" placeholder="Search" />
                        <span class="input-group-btn">
                        <button class="btn btn-info btn-lg" type="button">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                        </span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </header>
      <div id="home" class="parallax first-section wow fadeIn" data-stellar-background-ratio="0.4" style="background-image:url('');">
         <div class="container">
            <div class="row">
               <div class="col-md-12 col-sm-12">
                  <div class="text-contant">
                     <h2>
                        <span class="center"></span></span><br><br>
                        <a href="" class="typewrite" data-period="1000" data-type='[ "WELCOME TO OSNA", "WE CARE YOUR HEALTH" ]'>
                        <span class="wrap"></span>
                        </a>
                     </h2>
                  </div>
               </div>
            </div>
            <!-- end row -->
         </div>
         <!-- end container -->
      </div>
      <!-- end section -->
      <div id="time-table" class="time-table-section">
         <div class="container">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
               <div class="row">
                  <div class="service-time one" style="background:#2895f1;">
                     <span class="info-icon"><i class="fa fa-ambulance" aria-hidden="true"></i></span>
                     <h3>OPD</h3>
                     <p>We offer full medical care for non-emergency conditions.</p>
                     
                  </div>
               </div>
            </div>


            <?php

function convertToAMPM($time) {
    return date("h:i A", strtotime($time));
}

try {
    // Prepare the SQL query for PostgreSQL
    $stmt = pg_prepare($con, "get_schedule", "SELECT monday_to_friday_start, monday_to_friday_end, saturday_start, saturday_end, sunday_start, sunday_end FROM admin_settings WHERE id = 1");
    $result = pg_execute($con, "get_schedule", array());

    // Check if we have data
    if ($result) {
        $row = pg_fetch_assoc($result);

        // Assign values or defaults if not found
        $monday_to_friday_start = $row['monday_to_friday_start'] ?? '08:00:00';
        $monday_to_friday_end = $row['monday_to_friday_end'] ?? '17:00:00';
        $saturday_start = $row['saturday_start'] ?? '08:00:00';
        $saturday_end = $row['saturday_end'] ?? '17:00:00';
        $sunday_start = $row['sunday_start'] ?? '10:00:00';
        $sunday_end = $row['sunday_end'] ?? '15:00:00';
    } else {
        // Default values if no data found
        $monday_to_friday_start = '08:00:00';
        $monday_to_friday_end = '17:00:00';
        $saturday_start = '08:00:00';
        $saturday_end = '17:00:00';
        $sunday_start = '10:00:00';
        $sunday_end = '15:00:00';
    }
} catch (Exception $e) {
    // Handle errors
    $monday_to_friday_start = "Error: " . $e->getMessage();
    $monday_to_friday_end = "Error: " . $e->getMessage();
    $saturday_start = "Error: " . $e->getMessage();
    $saturday_end = "Error: " . $e->getMessage();
    $sunday_start = "Error: " . $e->getMessage();
    $sunday_end = "Error: " . $e->getMessage();
}
?>

           
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="row">
                <div class="service-time middle" style="background:#0071d1;">
                    <span class="info-icon"><i class="fa fa-clock-o" aria-hidden="true"></i></span> 
                    <h3>Working Hours</h3>
                    <div class="time-table-section">
                        <ul>
                        <li><span class="left">Monday - Friday</span><span class="right"><?php echo htmlspecialchars(convertToAMPM($monday_to_friday_start)) . ' - ' . htmlspecialchars(convertToAMPM($monday_to_friday_end)); ?></span></li>
                        <li><span class="left">Saturday</span><span class="right"><?php echo htmlspecialchars(convertToAMPM($saturday_start)) . ' - ' . htmlspecialchars(convertToAMPM($saturday_end)); ?></span></li>
                        <li><span class="left">Sunday</span><span class="right"><?php echo htmlspecialchars(convertToAMPM($sunday_start)) . ' - ' . htmlspecialchars(convertToAMPM($sunday_end)); ?></span></li>
                        </ul>
                    </div>
                </div>
            </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
               <div class="row">
                  <div class="service-time three" style="background:#0060b1;">
                     <span class="info-icon"><i class="fa fa-hospital-o" aria-hidden="true"></i></span>
                     <h3>Health Checkups</h3>
                     <p>Check Vital Signs</p>
                     <p>Patient Details</p>
                     <p>General Records</p>
                     
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div id="about" class="section wow fadeIn">
         <div class="container">
            <div class="heading">
               <span class="icon-logo"><img src="./img/opd1.png" alt="#"></span>
               <h2>OSNA</h2>
            </div>
           
            <?php

include_once 'db.php';

try {
    // Prepare the SQL query for PostgreSQL
    $stmt = pg_prepare(
        $con,
        "get_admin_settings",
        "SELECT what_we_do, osna_service, class_lead_description, image_path FROM admin_settings WHERE id = 1"
    );

    // Execute the prepared statement
    $result = pg_execute($con, "get_admin_settings", array());

    if ($result) {
        $row = pg_fetch_assoc($result);

        // Set global variables with fallback defaults
        $global_what_we_do = !empty($row['what_we_do']) ? $row['what_we_do'] : 'What We Do';
        $global_osna_service = !empty($row['osna_service']) ? $row['osna_service'] : 'OSNA Service';
        $global_class_lead = !empty($row['class_lead_description']) ? $row['class_lead_description'] : 'We offer a range of medical services to meet your health needs.';
        $imagePath = !empty($row['image_path']) ? $row['image_path'] : null;
    } else {
        // Set defaults if no results are returned
        $global_what_we_do = 'What We Do';
        $global_osna_service = 'OSNA Service';
        $global_class_lead = 'We offer a range of medical services to meet your health needs.';
        $imagePath = null;
    }
} catch (Exception $e) {
    // Handle any exceptions and set error messages as default values
    $global_what_we_do = "Error: " . $e->getMessage();
    $global_osna_service = "Error: " . $e->getMessage();
    $global_class_lead = "Error: " . $e->getMessage();
    $imagePath = null;
}

?>


            <div class="row">
                <div class="col-md-6">
                    <div class="message-box">
                        <h4><?php echo htmlspecialchars($global_what_we_do); ?></h4>
                        <h2><?php echo htmlspecialchars($global_osna_service); ?></h2>
                        <p class="lead"><?php echo htmlspecialchars($global_class_lead); ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                <div>
                        <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Image" width="100" class="img-thumbnail mt-3">
                    </div>
                </div>
            </div>

	  <div id="doctors" class="parallax section db" data-stellar-background-ratio="0.4" style="background:#fff;" data-scroll-id="doctors" tabindex="-1">
        <div class="container">
		
		<div class="heading">
              
               <h2>OPD CLERK</h2>
            </div>

            <div class="row dev-list text-center">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.2s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.2s; animation-name: fadeIn;">
                    
                </div><!-- end col -->

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.4s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.4s; animation-name: fadeIn;">
                    <div class="widget clearfix">
                        <img src="./img/nurse.jp" alt="" class="img-responsive img-rounded">
                        <div class="widget-title">
                            <h3>Georgia P. Almodovar</h3>
                            <small>OPD CLERK</small>
                        </div>
                        <!-- end title -->
                     

                        <div class="footer-social">
                        <a href="https://www.facebook.com/login" target="_blank" class="btn grd1">
                          <i class="fa fa-facebook"></i>
                        </a>

                        <a href="https://twitter.com/login" target="_blank" class="btn grd1">
                            <i class="fa fa-twitter"></i>
                        </a>

                            
                        </div>
                    </div><!--widget -->
                </div><!-- end col -->

                
            </div><!-- end row -->
        </div><!-- end container -->
    </div>
	  
	  
	  <!-- end doctor section -->
	 <hr>


    <div id="login" class="parallax section db" data-stellar-background-ratio="0.4" style="background:#fff;" data-scroll-id="doctors" tabindex="-1">
    <div class="container"> 
        <br><br>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">


        <div class="container py-5">
            <h2 class="text-center mb-3"><strong>Please Login Here</strong></h2>
            <p class="text-center">Select your role</p>
            <div class="row justify-content-center">
                <!-- Admin Login -->
                <div class="col-md-4 mb-3">
                    <div class="card text-center shadow h-100" onclick="location.href='../admin/login.php';" style="cursor: pointer;">
                        <div class="card-body">
                            <i class="fas fa-user-shield fa-3x text-primary mb-3"></i>
                            <h3 style="color: black;">Admin Login</h3>
                            <p class="card-text">Login as an administrator to manage system settings.</p>
                            <button class="btn btn-primary fw-bold">Login</button>
                        </div>
                    </div>
                </div>
                <!-- Clerk Login -->
                <div class="col-md-4 mb-3">
                    <div class="card text-center shadow h-100" onclick="location.href='../clerk/login.php';" style="cursor: pointer;">
                        <div class="card-body">
                            <i class="fas fa-user-tie fa-3x text-success mb-3"></i>
                            <h3 style="color: black;">Clerk Login</h3>
                            <p class="card-text">Login as a clerk to manage patient information.</p>
                            <button class="btn btn-success fw-bold">Login</button>
                        </div>
                    </div>
                </div>
                <!-- Doctor Login -->
                <div class="col-md-4 mb-3">
                    <div class="card text-center shadow h-100" onclick="location.href='../doctor2/login.php';" style="cursor: pointer;">
                        <div class="card-body">
                            <i class="fas fa-user-md fa-3x text-danger mb-3"></i>
                            <h3 style="color: black;">Doctor Login</h3>
                            <p class="card-text">Login as a doctor to access patient records and schedules.</p>
                            <button class="btn btn-danger fw-bold">Login</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </section>
    
    <style>
    /* Login Container Styles */
.login__container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
}

/* Login Card Styles */
.login__card {
    background-color: #f8f9fa;
    border: 1px solid #e3e6f0;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    flex: 1 1 calc(33.333% - 40px); /* Adjust card width and spacing */
    max-width: calc(33.333% - 40px);
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    transition: transform 0.3s ease;
}

.login__card:hover {
    transform: scale(1.05);
}

/* Button Styles */
.btn-login {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bolder;
}

.btn-login:hover {
    background-color: #0056b3;
}

/* Responsive Styles */
@media (max-width: 992px) {
    .login__card {
        flex: 1 1 calc(50% - 40px);
        max-width: calc(50% - 40px);
    }
}

@media (max-width: 576px) {
    .login__card {
        flex: 1 1 100%;
        max-width: 100%;
    }
}
    </style>
    
  





      <!-- end section -->
      <div id="getintouch" class="section wb wow fadeIn" style="padding-bottom:0;">
         <div class="container">
             <div class="heading">
                 <span class="icon-logo"> <img src="<?php echo htmlspecialchars($image); ?>" alt="Website Logo" width="200px" height="100px"></span>
                 <h2>Get in Touch</h2>
             </div>
         </div>
         <div class="contact-section">
             <div class="form-contant">
                 <form id="ajax-contact" action="https://formspree.io/f/xblrdjvy" method="post">
                     <div class="row">
                         <div class="col-md-6">
                             <div class="form-group in_name">
                                 <input type="text" class="form-control" name="name" placeholder="Name" required="required">
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group in_email">
                                 <input type="email" class="form-control" name="email" placeholder="E-mail" required="required">
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group in_email">
                                 <input type="tel" class="form-control" name="phone" id="phone" placeholder="Phone" required="required">
                             </div>
                         </div>
                         <div class="col-md-6">
                             <div class="form-group in_email">
                                 <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required="required">
                             </div>
                         </div>
                         <div class="col-md-12">
                             <div class="form-group in_message"> 
                                 <textarea class="form-control" name="message" id="message" rows="5" placeholder="Message" required="required"></textarea>
                             </div>
                             <div class="actions">
                                 <input type="submit" value="Send Message" name="submit" id="submitButton" class="btn small" title="Submit Your Message!">
                             </div>
                         </div>
                     </div>
                 </form>
             </div>
             <div id="googleMap" style="width:100%;height:450px;"></div>
         </div>
     </div>
     <script>
         function myMap() {
             var mapProp = {
                 center: new google.maps.LatLng(14.074444, 120.632222),
                 zoom: 15,
             };
             var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
         }
     </script>
     <script src="https://maps.googleapis.com/maps/api/js?callback=myMap" async defer></script>
     





      
      <footer id="footer" class="footer-area wow fadeIn">
         <div class="container">
            <div class="row">
               <div class="col-md-4">
                  <div class="logo padding">
                     <a href=""> <img src="<?php echo htmlspecialchars($image); ?>" alt="Website Logo"></a>
                     
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="footer-info padding">
                     <h3>CONTACT US</h3>

                     <?php
include_once 'db.php'; // Ensure this connects to your PostgreSQL database

// Define global variable
$global_address = "";

// Fetch the address from the database
try {
    // Prepare the SQL query for PostgreSQL
    $stmt = pg_prepare(
        $con,
        "get_address",
        "SELECT address FROM admin_settings WHERE id = 1"
    );

    // Execute the prepared statement
    $result = pg_execute($con, "get_address", array());

    if ($result) {
        $row = pg_fetch_assoc($result);

        if ($row && !empty($row['address'])) {
            $global_address = $row['address'];
        } else {
            $global_address = "Address not available.";
        }
    } else {
        $global_address = "Address not available.";
    }
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
}
?>


<div style="color:black;">
    <p style="color: black;">
        <i class="fa fa-map-marker" aria-hidden="true"></i> 
        <?php echo htmlspecialchars($global_address); ?>
    </p>
    <p>
        <i class="fa fa-paper-plane" aria-hidden="true"></i> 
        <a href="mailto:<?php echo htmlspecialchars($email); ?>" target="_blank" rel="noopener noreferrer">
            <?php echo htmlspecialchars($email); ?>
        </a>
    </p>
    <p>
        <i class="fa fa-phone" aria-hidden="true"></i> 
        <a href="tel:<?php echo htmlspecialchars($phone_number); ?>">
            <?php echo htmlspecialchars($phone_number); ?>
        </a>
    </p>
</div>

                  </div>
               </div>
               
            </div>
         </div>
            
      </footer>
      <div class="copyright-area wow fadeIn">
         <div class="container">
            <div class="row">
               <div class="col-md-8">
                  <div class="footer-text">
                     <p>© 2024 OSNA. All Rights Reserved.</p>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="social">
                     <ul class="social-links">
                     <li>
                    <a href="https://www.facebook.com/login" target="_blank">
                        <i class="fa fa-facebook"></i>
                    </a>
                </li>
                <li>
                    <a href="https://twitter.com/login" target="_blank">
                        <i class="fa fa-twitter"></i>
                    </a>
                </li>

                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end copyrights -->
      <a href="#home" data-scroll class="dmtop global-radius"><i class="fa fa-angle-up"></i></a>
      <!-- all js files -->
      <script src="js/all.js"></script>
      <!-- all plugins -->
      <script src="js/custom.js"></script>
      <!-- map -->
      <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>

     <script>
   document.addEventListener("DOMContentLoaded", function() {
       // Tiyakin na laging magre-refresh sa home section
       if (localStorage.getItem('scrollToHome') !== 'false') {
           localStorage.setItem('scrollToHome', 'true');
           window.location.hash = '#home';
       }
   });

   window.addEventListener('beforeunload', function() {
       // Set the value to false before page unload to avoid unwanted scroll
       localStorage.setItem('scrollToHome', 'false');
   });
</script>



   </body>
</html>
