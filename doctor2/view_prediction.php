<!DOCTYPE html>
<html lang="en">
    
<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:20 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>View Prediction</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/opd.png">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
		
		<!-- Feathericon CSS -->
        <link rel="stylesheet" href="assets/css/feathericon.min.css">
		
		<link rel="stylesheet" href="assets/plugins/morris/morris.css">
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="assets/css/style.css">
		
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->

		<?php
  session_start();
  include 'db.php'; 
?>

<?php
				if (!isset($_SESSION['username'])) {
					
					header("Location: login.php");
					exit();
				}
				
				$username = $_SESSION['username'];
				
				// Prepare SQL query using PostgreSQL
				$sql = "SELECT doctor_name, doctor_image FROM doctor_log WHERE username = $1";
				$stmt = pg_prepare($con, "get_doctor_details", $sql);
				$result = pg_execute($con, "get_doctor_details", array($username));

				if ($result) {
					$user = pg_fetch_assoc($result);
					if ($user) {
						
						$name = $user['doctor_name'];
						$image = $user['doctor_image'];
					} else {
					
						$name = "Unknown";
					}
				} else {
					
					$name = "Unknown";
				}
?>

<?php

// Fetch patient information
$sql = "SELECT name, address, contactnum, age, sex, civil_status FROM patient_info";
$result = pg_query($con, $sql);
?>

    </head>
    <body>
	
		<!-- Main Wrapper -->
        <div class="main-wrapper">
		
			<!-- Header -->
            <div class="header">
			
				<!-- Logo -->
                <div class="header-left">
                    <a href="" class="logo">
						<img src="assets/img/opd.png" alt="Logo">
					</a>
					<a href="" class="logo logo-small">
						<img src="assets/img/opd.png" alt="Logo" width="30" height="30">
					</a>
                </div>
				<!-- /Logo -->
				
				<a href="javascript:void(0);" id="toggle_btn">
					<i class="fe fe-text-align-left"></i>
				</a>
				
				<div class="top-nav-search">
				
				</div>
				
				<!-- Mobile Menu Toggle -->
				<a class="mobile_btn" id="mobile_btn">
					<i class="fa fa-bars"></i>
				</a>
				<!-- /Mobile Menu Toggle -->
				
				<!-- Header Right Menu -->
				<ul class="nav user-menu">

					
					
					<!-- User Menu -->
					<li class="nav-item dropdown has-arrow">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
						<span class="user-img">
					
						<img src="images/<?php echo htmlspecialchars($image); ?>" alt="Doctor Image" class="img-circle" />
					</span>

					<style>
						.user-img img.img-circle {
							width: 50px;        
							height: 50px;       
							border-radius: 50%; 
							object-fit: cover;  
						}

					</style>


						</a>
						<div class="dropdown-menu">
							<div class="user-header">
								<div class="avatar avatar-sm">
								<img src="images/<?php echo htmlspecialchars($image); ?>" alt="Doctor Image" class="img-circle" />
								</div>
								<div class="user-text">
								<h6><?php echo $username; ?></h6>
									<p class="text-muted mb-0" style="font-size: 13px;"><?php echo $name; ?></p>
								</div>
							</div>
							<a class="dropdown-item" href="profile.php">My Profile</a>
							<a class="dropdown-item" href="settings.php">Settings</a>
							<a class="dropdown-item" href="login.php">Logout</a>
						</div>
					</li>
					<!-- /User Menu -->
					
				</ul>
				<!-- /Header Right Menu -->
				
            </div>
			<!-- /Header -->
			<style>
				.fa {
					margin-right: 8px;
				}

			 </style>
			
	<!-- Sidebar -->
	<div class="sidebar" id="sidebar">
                <div class="sidebar-inner slimscroll">
					<div id="sidebar-menu" class="sidebar-menu">
						<ul>
							<li class="menu-title"> 
								<span>Main</span>
							</li>
							<li class="active"> 
								<a href="doctor_dash2.php"><i class="fe fe-home"></i> <span>Dashboard</span></a>
							</li>
							<li class="submenu">
								<a href="#"><i class="fa fa-wheelchair"></i> <span>Prescription</span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
								<li><a href="prescription.php"><i class="fa fa-plus"></i> &nbsp;Add Prescription</a></li>
								
								</ul>

								<li><a href="patient_list.php"><i class="fa fa-info-circle"></i> &nbsp; Patient List</a></li>
								<li>
							<a href="login.php"><i class="fa fa-sign-out"></i> <span>Logout</span></a>
							</li>
					</div>
                </div>
            </div>
			<!-- /Sidebar -->
  <!-- Page Wrapper -->
  <div class="page-wrapper">
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Prescription</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="doctor_dash2.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Prescription | View History</li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
// consult_patient.php

// Connect to database
include('db.php');

// Retrieve username from URL
$username = isset($_GET['username']) ? $_GET['username'] : null;
$success = isset($_GET['success']) ? $_GET['success'] : null;

if ($username) {
    // Fetch patient data from database
    $query = "SELECT * FROM patient_info WHERE username = $1";
    $result = pg_query_params($con, $query, array($username));
    $patient = pg_fetch_assoc($result);
    
    if ($patient) {
        ?>

        <div style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
           <!-- Top Buttons Row -->
<div class="d-flex mb-4">
    <!-- Add Vital Signs Button -->
    <a href="add_prescription.php?username=<?php echo urlencode($username); ?>" class="blue-link">
        <i class="fa fa-plus"></i> Prescription
    </a>&nbsp; &nbsp; &nbsp;


    <a href="view_prescription.php?username=<?php echo urlencode($username); ?>" class="blue-link" style="border-radius: 8px;">
    <i class="fa fa-"></i> View Prescription
</a>


</div>



<style>
   .blue-link {
    color: #007BFF; /* Primary blue */
    text-decoration: none;
    font-size: 16px;
    font-weight: bold;
    border: 2px solid #007BFF; /* Blue border */
    border-radius: 5px; /* Rounded corners */
    padding: 5px 10px; /* Space inside the border */
    display: inline-block; /* Ensure the border wraps the content */
    transition: background-color 0.3s, color 0.3s; /* Smooth transition for hover */
}

.blue-link i {
    color: #0056b3; /* Darker blue for the icon */
    font-size: 18px;
    margin-right: 5px; /* Space between the icon and text */
}

.blue-link:hover {
    color: #ffffff; /* Change text color on hover */
    background-color: #007BFF; /* Fill background on hover */
}

.blue-link i:hover {
    color: #ffffff; /* Change icon color on hover */
}

</style>


                <!-- Predict Diagnosis Button -->
               
            </div>
            <div class="row">
    <!-- Patient Details Section (Left Column) -->
    <div class="col-md-8">
        <div class="card shadow-sm border-light mb-4" style="border-radius: 10px; overflow: hidden;">
            <div class="card-header bg-primary text-white" style="border-bottom: 2px solid #004085;">
                <h2 class="mb-0">Patient Details</h2>
            </div>
            <div class="card-body" style="background-color: #f7f8fa;">
                <!-- Patient details in table format -->
                <table class="table table-borderless">
                    <tbody>
                        <tr><th>Name</th><td><?php echo htmlspecialchars($patient['name']); ?></td></tr>
                        <tr><th>Address</th><td><?php echo htmlspecialchars($patient['address']); ?></td></tr>
                        <tr><th>Contact Number</th><td><?php echo htmlspecialchars($patient['contactnum']); ?></td></tr>
                        <tr><th>Age</th><td><?php echo htmlspecialchars($patient['age']); ?></td></tr>
                        <tr><th>Sex</th><td><?php echo htmlspecialchars($patient['sex']); ?></td></tr>
                        <tr><th>Civil Status</th><td><?php echo htmlspecialchars($patient['civil_status']); ?></td></tr>
                    </tbody>
                </table>

                <!-- Success message for vital signs added -->
                <?php if ($success): ?>
                    <div class="alert alert-success mt-3" style="border-radius: 8px;">
                        <strong>Success!</strong> Vital signs added successfully!
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

  <!-- History Section (Right Column) -->
  <div class="col-md-4">
    <!-- Guide Section -->
    <div class="card shadow-sm border-light mb-4" style="border-radius: 10px; overflow: hidden;">
        <div class="card-header bg-secondary text-white" style="border-bottom: 2px solid #6c757d;">
            <h6 class="mb-0">Guide</h6>
        </div>
        <div class="card-body text-left" style="background-color: #f1f3f5;">
            <p>Follow the steps below to add a prescription:</p>
            <ul class="text-start" style="font-size: 14px;"> <!-- Smaller font size for list items -->
                <li>Step 1: Click the "Add Prescription" button.</li>
                <li>Step 2: Navigate to the "Add Prescription" form.</li>
                <li>Step 3: Complete the form with the prescription details and save.</li>
            </ul>
            <p>Additional Information:</p>
            <ul class="text-start" style="font-size: 14px;"> <!-- Smaller font size for list items -->
                <li>You can also access the "View Prescription" to print.</li>
                
            </ul>
        </div>
    </div>
</div>





<!-- Add Bootstrap JS for modal functionality (if not included already) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

        </div>

        <?php
    } else {
        echo "<div class='container mt-5'><p class='text-danger text-center'>Patient not found.</p></div>";
    }
} else {
    echo "<div class='container mt-5'><p class='text-warning text-center'>No patient selected.</p></div>";
}

// Close database connection
pg_close($con);
?>









 <!-- for displaying patient data  -->
   

    <!-- jQuery -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
