<!DOCTYPE html>
<html lang="en">
    
<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:20 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Admin</title>
		
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
		
		
		
	<?php
// Siguraduhing walang whitespace o bagong linya bago ang PHP tags.
session_start();
include '../db.php'; // Siguraduhing tama ang relative path ng db.php

if (!isset($_SESSION['username'])) {
    // Kung walang naka-log in, i-redirect sa login page.
    header("Location: /osna/admin/login.php");
    exit();
}

$adminusername = $_SESSION['username'];

try {
    // Query para bilangin ang doctors
    $stmtDoctors = pg_prepare($con, "count_doctors", "SELECT COUNT(*) as count FROM doctor_log");
    $resultDoctors = pg_execute($con, "count_doctors", array());
    $countDoctors = ($row = pg_fetch_assoc($resultDoctors)) ? $row['count'] : 0;

    // Query para bilangin ang patients
    $stmtPatients = pg_prepare($con, "count_patients", "SELECT COUNT(*) as count FROM patient_info");
    $resultPatients = pg_execute($con, "count_patients", array());
    $countPatients = ($row = pg_fetch_assoc($resultPatients)) ? $row['count'] : 0;

    // Query para bilangin ang clerks
    $stmtClerks = pg_prepare($con, "count_clerks", "SELECT COUNT(*) as count FROM clerk_log");
    $resultClerks = pg_execute($con, "count_clerks", array());
    $countClerks = ($row = pg_fetch_assoc($resultClerks)) ? $row['count'] : 0;

    // Query para kunin ang pangalan ng admin
    $stmt = pg_prepare($con, "get_admin_name", "SELECT name FROM admin_log WHERE username = $1");
    $result = pg_execute($con, "get_admin_name", array($adminusername));

    $name = ($user = pg_fetch_assoc($result)) ? $user['name'] : "Unknown";
} catch (Exception $e) {
    $countDoctors = $countPatients = $countClerks = $name = "Error: " . htmlspecialchars($e->getMessage());
}

// Close the connection
pg_close($con);
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
							<span class="user-img"><img class="rounded-circle" src="./assets/img/profiles/profile.jpeg" width="31" alt="admin"></span>
						</a>
						<div class="dropdown-menu">
							<div class="user-header">
								<div class="avatar avatar-sm">
									<img src="./assets/img/profiles/profile.jpeg" alt="User Image" class="avatar-img rounded-circle">
								</div>
								<div class="user-text">
								<h6><?php echo $adminusername; ?></h6>
									<p class="text-muted mb-0"><?php echo $name; ?></p>
								</div>
							</div>
							<a class="dropdown-item" href="profile.php">My Profile</a>
							<a class="dropdown-item" href="settings.php">Web Settings</a>
							<a class="dropdown-item" href="./login.php">Logout</a>
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
								<h3 class="page-title">Welcome, <?php echo $name; ?></h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item active">Dashboard</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					 <style>
						.card-link {
    text-decoration: none;
    color: inherit;
    display: block;
}

.card-link .card {
    transition: transform 0.3s ease;
}

.card-link:hover .card {
    transform: scale(1.05);
}
.card-body{
	border: 1px solid grey;
	border-radius: 10px;
}


					 </style>
					<div class="row justify-content-center row-sm">
						<div class="col-xl-3 col-sm-6 col-12">
							<a href="patient.php" class="card-link">
								<div class="card">
									<div class="card-body">
										<div class="dash-widget-header">
											<span class="dash-widget-icon text-success">
												<i class="fe fe-credit-card"></i>
											</span>
											<div class="dash-count">
												<p><?php echo $countPatients; ?></p>
											</div>
										</div>
										<div class="dash-widget-info">
											<h6 class="text-muted">Total Patients</h6>
											<div class="progress progress-sm">
												<div class="progress-bar bg-warning" id="patientProgressBar" data-count="<?php echo $countPatients; ?>"></div>
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>
						
						
						<div class="col-xl-3 col-sm-6 col-12">
							<a href="doctor.php" class="card-link">
								<div class="card">
									<div class="card-body">
										<div class="dash-widget-header">
											<span class="dash-widget-icon text-primary border-primary">
												<i class="fe fe-users"></i>
											</span>
											<div class="dash-count">
												<p><?php echo $countDoctors; ?></p>
											</div>
										</div>
										<div class="dash-widget-info">
											<h6 class="text-muted">Total Doctors</h6>
											<div class="progress progress-sm">
												<div class="progress-bar bg-warning" id="doctorProgressBar" data-count="<?php echo $countDoctors; ?>"></div>
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>


						<div class="col-xl-3 col-sm-6 col-12">
							<a href="clerk.php" class="card-link">
								<div class="card">
									<div class="card-body">
										<div class="dash-widget-header">
											<span class="dash-widget-icon text-warning border-warning">
												<i class="fe fe-folder"></i>
											</span>
											<div class="dash-count">
												<p><?php echo $countClerks; ?></p>
											</div>
										</div>
										<div class="dash-widget-info">
											<h6 class="text-muted">Total Clerks</h6>
											<div class="progress progress-sm">
												<div class="progress-bar bg-warning" id="clerkProgressBar" data-count="<?php echo $countClerks; ?>"></div>
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>
					</div>
					



   

    







    
</body>

		<!-- /Main Wrapper -->
		
		<!-- jQuery -->
        <script src="assets/js/jquery-3.2.1.min.js"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
		
		<!-- Slimscroll JS -->
        <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		
		<script src="assets/plugins/raphael/raphael.min.js"></script>    
		<script src="assets/plugins/morris/morris.min.js"></script>  
		<script src="assets/js/chart.morris.js"></script>
		
		<!-- Custom JS -->
		<script  src="assets/js/script.js"></script>
		
    </body>

<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:34 GMT -->
</html>
