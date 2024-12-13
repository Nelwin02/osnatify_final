<?php
// Start session
session_start();
include '../db.php'; // Ensure the correct path to db.php

// Redirect to login if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: /osna/admin/login.php");
    exit();
}

$username = $_SESSION['username'];

// Use PostgreSQL's parameterized query to prevent SQL injection
$sql = "SELECT name FROM admin_log WHERE username = $1";
$result = pg_query_params($con, $sql, array($username));

$name = "Unknown"; // Default value
if ($result) {
    $user = pg_fetch_assoc($result);
    if ($user) {
        $name = $user['name'];
    }
}

// Free the result resource
pg_free_result($result);
?>
<!DOCTYPE html>
<html lang="en">
    
<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:20 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Admin Settings</title>
		
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
							<span class="user-img"><img class="rounded-circle" src="./assets/img/profiles/profile.jpeg" width="31" alt="admin"></span>
						</a>
						<div class="dropdown-menu">
							<div class="user-header">
								<div class="avatar avatar-sm">
									<img src="./assets/img/profiles/profile.jpeg" alt="User Image" class="avatar-img rounded-circle">
								</div>
								<div class="user-text">
								<h6><?php echo $username; ?></h6>
									<p class="text-muted mb-0">Administrator</p>
								</div>
							</div>
							<a class="dropdown-item" href="profile.php">My Profile</a>
							<a class="dropdown-item" href="settings.php">Web Settings</a>
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
    margin-right: 8px; /* Add some space between the icon and text */
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
								<a href="admin_dash.php"><i class="fe fe-home"></i> <span>Dashboard</span></a>
							</li>
							<li class="submenu">
								<a href="#"><i class="fa fa-wheelchair"></i> <span>Manage Patient</span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
								<li><a href="manage_patient.php"><i class="fa fa-info-circle"></i>Patient Information</a></li>
								<li><a href="patient.php"><i class="fa fa-stethoscope"></i>Health Records</a></li>
								</ul>
								<li class="submenu">
									<a href="#"><i class="fa fa-user-md"></i> <span>Manage Doctors</span> <span class="menu-arrow"></span></a>
									<ul style="display: none;">
									<li><a href="add_doctor.php"><i class="fa fa-user-plus"></i> Add Doctor</a></li>
									<li><a href="doctor.php"><i class="fa fa-user-md"></i> Doctor List</a></li>
									</ul>
								</li>
								<li class="submenu">
									<a href="#"><i class="fa fa-user"></i> <span>Manage Clerk</span> <span class="menu-arrow"></span></a>
									<ul style="display: none;">
									<li><a href="add_clerk.php"><i class="fa fa-user-plus"></i> Add Clerk</a></li>
									<li><a href="clerk.php"><i class="fa fa-user-md"></i> Clerk List</a></li>
									</ul>
								</li>
							<li> 

                            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

							<li class="submenu">
                                <a href="#"><i class="fas fa-bullhorn"></i> <span>Announcement</span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                <li><a href="add_announcement.php"><i class="fas fa-plus"></i>  Add Announcement</a></li>
                                
                                </ul>
                            </li>
	
							<li> 
								<a href="settings.php"><i class="fe fe-vector"></i> <span>Web Settings</span></a>
							</li>
							
							<li> 
								<a href="profile.php"><i class="fe fe-user-plus"></i> <span>Profile</span></a>
							</li><br><br><br><br><br><br><br><br>
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
								<h3 class="page-title">Web Settings</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="admin_dash.php">Dashboard</a></li>
									<li class="breadcrumb-item"><a href="javascript:(0)">Web Settings</a></li>
									
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						
						<div class="col-12">
							
							<!-- General -->
							
             <?php
// Include the database connection file
include_once 'db.php'; 

// Update form values when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and fetch form inputs
    $newPhoneNumber = $_POST['phone_number'];
    $newEmail = $_POST['email'];
    $newOpeningTime = $_POST['opening_time'];
    $newClosingTime = $_POST['closing_time'];
    $mondayToFridayStart = $_POST['monday_to_friday_start'];
    $mondayToFridayEnd = $_POST['monday_to_friday_end'];
    $saturdayStart = $_POST['saturday_start'];
    $saturdayEnd = $_POST['saturday_end'];
    $sundayStart = $_POST['sunday_start'];
    $sundayEnd = $_POST['sunday_end'];
    $newAddress = $_POST['address'];
    $newWhatWeDo = $_POST['what_we_do'];
    $newOsnaService = $_POST['osna_service'];
    $newClassLeadDescription = $_POST['class_lead_description'];

    // File upload handling
    if (isset($_FILES['image_path']) && $_FILES['image_path']['error'] === UPLOAD_ERR_OK) {
        $imageName = preg_replace("/[^a-zA-Z0-9\._-]/", "", $_FILES['image_path']['name']);
        $tempName = $_FILES['image_path']['tmp_name'];

        // Target folder inside `osna/images/`
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/osna/images/';
        $targetPath = $targetDir . basename($imageName);

        // Ensure the `images` directory exists
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true); // Create folder if it doesn't exist
        }

        // Validate file type
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            die("<div class='alert alert-danger'>Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.</div>");
        }

        // Move uploaded file
        if (move_uploaded_file($tempName, $targetPath)) {
            // Save relative path to the database (e.g., `images/example.jpg`)
            $relativePath = '/osna/images/' . basename($imageName);
        } else {
            die("<div class='alert alert-danger'>Failed to upload image. Please try again.</div>");
        }
    } else {
        $relativePath = null; // No new image uploaded
    }

    // PostgreSQL Database update
    try {
        $sql = "UPDATE admin_settings SET 
                phone_number = $1, 
                email = $2, 
                opening_time = $3, 
                closing_time = $4, 
                monday_to_friday_start = $5, 
                monday_to_friday_end = $6, 
                saturday_start = $7, 
                saturday_end = $8, 
                sunday_start = $9, 
                sunday_end = $10, 
                address = $11, 
                what_we_do = $12, 
                osna_service = $13, 
                class_lead_description = $14, 
                image_path = COALESCE($15, image_path) 
                WHERE id = 1";

        $params = [
            $newPhoneNumber, 
            $newEmail, 
            $newOpeningTime, 
            $newClosingTime, 
            $mondayToFridayStart, 
            $mondayToFridayEnd, 
            $saturdayStart, 
            $saturdayEnd, 
            $sundayStart, 
            $sundayEnd, 
            $newAddress, 
            $newWhatWeDo, 
            $newOsnaService, 
            $newClassLeadDescription, 
            $relativePath
        ];

        // Prepare and execute the query
        $stmt = pg_prepare($con, "update_settings", $sql);
        $result = pg_execute($con, "update_settings", $params);

        if ($result) {
            echo "<div class='alert alert-success'>Web Settings Updated successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error updating settings: " . pg_last_error($con) . "</div>";
        }
    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}

// Fetch current values from the database
$sql = "SELECT 
            phone_number, 
            email, 
            opening_time, 
            closing_time, 
            monday_to_friday_start, 
            monday_to_friday_end, 
            saturday_start, 
            saturday_end, 
            sunday_start, 
            sunday_end, 
            address, 
            what_we_do, 
            osna_service, 
            class_lead_description, 
            image_path 
        FROM admin_settings WHERE id = 1";

$result = pg_query($con, $sql);

if ($result) {
    $row = pg_fetch_assoc($result);

    $phone_number = $row['phone_number'] ?? '';
    $email = $row['email'] ?? '';
    $opening_time = $row['opening_time'] ?? '08:00:00';
    $closing_time = $row['closing_time'] ?? '20:00:00';
    $monday_to_friday_start = $row['monday_to_friday_start'] ?? '08:00:00';
    $monday_to_friday_end = $row['monday_to_friday_end'] ?? '17:00:00';
    $saturday_start = $row['saturday_start'] ?? '08:00:00';
    $saturday_end = $row['saturday_end'] ?? '17:00:00';
    $sunday_start = $row['sunday_start'] ?? '10:00:00';
    $sunday_end = $row['sunday_end'] ?? '15:00:00';
    $address = $row['address'] ?? '';
    $what_we_do = $row['what_we_do'] ?? 'What We Do';
    $osna_service = $row['osna_service'] ?? 'OSNA Service';
    $class_lead_description = $row['class_lead_description'] ?? 'We offer a comprehensive range of medical services designed to meet your health needs.';
    $imagePath = $row['image_path'] ?? '';
}
?>


<!-- Bootstrap Form with Rows and Icons -->
<form method="POST" action="settings.php" enctype="multipart/form-data" class="settings-form container py-4">
    <!-- Row for Phone Number and Email -->
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="phone_number" class="form-label">
                <i class="fa fa-phone"></i> Phone Number
            </label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>" class="form-control">
        </div>
        <div class="col-md-6">
            <label for="email" class="form-label">
                <i class="fa fa-envelope"></i> Email
            </label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" class="form-control">
        </div>
    </div>

    <!-- Row for Opening and Closing Time -->
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="opening_time" class="form-label">
                <i class="fa fa-clock-o"></i> Opening Time
            </label>
            <input type="time" id="opening_time" name="opening_time" value="<?php echo htmlspecialchars($opening_time); ?>" class="form-control">
        </div>
        <div class="col-md-6">
            <label for="closing_time" class="form-label">
                <i class="fa fa-clock-o"></i> Closing Time
            </label>
            <input type="time" id="closing_time" name="closing_time" value="<?php echo htmlspecialchars($closing_time); ?>" class="form-control">
        </div>
    </div>

    <!-- Monday to Friday Timing -->
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="monday_to_friday_start" class="form-label">
                <i class="fa fa-calendar"></i> Monday to Friday Start
            </label>
            <input type="time" id="monday_to_friday_start" name="monday_to_friday_start" value="<?php echo htmlspecialchars($monday_to_friday_start); ?>" class="form-control">
        </div>
        <div class="col-md-6">
            <label for="monday_to_friday_end" class="form-label">
                <i class="fa fa-calendar"></i> Monday to Friday End
            </label>
            <input type="time" id="monday_to_friday_end" name="monday_to_friday_end" value="<?php echo htmlspecialchars($monday_to_friday_end); ?>" class="form-control">
        </div>
    </div>

    <!-- Weekend Timing -->
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="saturday_start" class="form-label">
                <i class="fa fa-calendar"></i> Saturday Start
            </label>
            <input type="time" id="saturday_start" name="saturday_start" value="<?php echo htmlspecialchars($saturday_start); ?>" class="form-control">
        </div>
        <div class="col-md-6">
            <label for="saturday_end" class="form-label">
                <i class="fa fa-calendar"></i> Saturday End
            </label>
            <input type="time" id="saturday_end" name="saturday_end" value="<?php echo htmlspecialchars($saturday_end); ?>" class="form-control">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="sunday_start" class="form-label">
                <i class="fa fa-calendar"></i> Sunday Start
            </label>
            <input type="time" id="sunday_start" name="sunday_start" value="<?php echo htmlspecialchars($sunday_start); ?>" class="form-control">
        </div>
        <div class="col-md-6">
            <label for="sunday_end" class="form-label">
                <i class="fa fa-calendar"></i> Sunday End
            </label>
            <input type="time" id="sunday_end" name="sunday_end" value="<?php echo htmlspecialchars($sunday_end); ?>" class="form-control">
        </div>
    </div>

    <!-- Address -->
    <div class="row mb-3">
        <div class="col-12">
            <label for="address" class="form-label">
                <i class="fa fa-map-marker"></i> Address
            </label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" class="form-control">
        </div>
    </div>

    <!-- Additional Details -->
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="what_we_do" class="form-label">
                <i class="fa fa-info-circle"></i> What We Do
            </label>
            <textarea id="what_we_do" name="what_we_do" class="form-control"><?php echo htmlspecialchars($what_we_do); ?></textarea>
        </div>
        <div class="col-md-4">
            <label for="osna_service" class="form-label">
                <i class="fa fa-cogs"></i> OSNA Service
            </label>
            <textarea id="osna_service" name="osna_service" class="form-control"><?php echo htmlspecialchars($osna_service); ?></textarea>
        </div>
        <div class="col-md-4">
            <label for="class_lead_description" class="form-label">
                <i class="fa fa-users"></i> Class Lead Description
            </label>
            <textarea id="class_lead_description" name="class_lead_description" class="form-control"><?php echo htmlspecialchars($class_lead_description); ?></textarea>
        </div>
    </div>

    <!-- File Upload and Logo -->
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="image_path" class="form-label">
                <i class="fa fa-upload"></i> Update Logo
            </label>
            <input type="file" id="image_path" name="image_path" class="form-control">
        </div>
      <div>
            <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Image" width="100" class="img-thumbnail mt-3">
        </div>
    </div>

    <!-- Submit Button -->
    <div class="row">
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> Save Changes
            </button>
        </div>
    </div>
</form>







							
							<!-- /General -->
								
						</div>
					</div>
					
				</div>			
			</div>
			<!-- /Page Wrapper -->
		
        </div>
		<!-- /Main Wrapper -->
		
		<!-- jQuery -->
        <script src="assets/js/jquery-3.2.1.min.js"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
		
		<!-- Slimscroll JS -->
        <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		
		<!-- Custom JS -->
		<script  src="assets/js/script.js"></script>
		
    </body>

<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/settings.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:46 GMT -->
</html>
