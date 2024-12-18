<?php
	// Start session
	session_start();
	include '../db.php'; // Ensure the correct path to db.php
	
	// Redirect to login if the user is not logged in
	if (!isset($_SESSION['username'])) {
	    header("Location: /osna/admin/login.php");
	    exit();
	}
    
    // Retrieve username from session
    $username = $_SESSION['username'];
    
    // Example query to fetch user details from the PostgreSQL database
    $sql = "SELECT * FROM admin_log WHERE username = $1";
    
    // Prepare the SQL statement
    $result = pg_prepare($con, "get_user", $sql);
    
    // Execute the query with the session username
    $result = pg_execute($con, "get_user", array($username));
    
    // Fetch the user details
    $user = pg_fetch_assoc($result);
    
    // Display the username or other user details
    // Example of displaying the username
    if ($user) {
        echo "Hello, " . htmlspecialchars($user['username']);
    } else {
        echo "User not found!";
    }
?>

<!DOCTYPE html>
<html lang="en">
    
<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:20 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Patient List</title>
		
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
							<span class="user-img"><img class="rounded-circle" src="./assets/img/profiles/profile.jpeg" width="31" alt="Ryan Taylor"></span>
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
								<li><a href="manage_patient.php"><i class="fa fa-info-circle"></i>Patient Records</a></li>
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
								<h3 class="page-title">List of Patient</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="admin_dash.php">Dashboard</a></li>
									<li class="breadcrumb-item active">Patient</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-sm-12">
							
							<div class="card">
								<div class="card-body">
									<div class="table-responsive">
										<table class="datatable table table-hover table-center mb-0">
									
											<tbody>

											<style>
        table {
            width: 100%; /* Make the table wider */
            margin: 20px auto; /* Center the table */
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd; /* Add border to table cells */
        }

        th {
            background-color: #f2f2f2; /* Add background color to header */
        }

        tr:hover {
            background-color: #f5f5f5; /* Add hover effect */
        }

        .btn {
            background-color: #007bff; /* Bootstrap primary color */
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        .btn i {
            margin-right: 5px; /* Space between icon and text */
        }
    </style>
								<?php
include 'db.php'; // Include your PostgreSQL database connection script

// Query to fetch patient info along with diagnosis and prescription from doctor_confirm table
$query = pg_query($con, "
    SELECT p.id, p.username, p.name, p.address, d.diagnosis, d.prescription
    FROM patient_info p
    LEFT JOIN doctor_confirm d ON p.id = d.patient_id
    ORDER BY p.id DESC
");


// Check if query executed successfully
if (!$query) {
    die('Error: ' . pg_last_error($con)); // Output any SQL error
}

// Start outputting table rows
echo "<table border='1'>"; // Adding a simple table for display

// Output table headers
echo "<tr>
        <th>ID</th>
        <th>Username</th>
        <th>Name</th>
        <th>Address</th>
        <th>Diagnosis</th>
        <th>Prescription</th>
        <th>Action</th>
    </tr>";

// Fetch and display each row using pg_fetch_assoc() for PostgreSQL
while ($row = pg_fetch_assoc($query)) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['username']}</td>
            <td>{$row['name']}</td>
            <td>{$row['address']}</td>
            <td>{$row['diagnosis']}</td>
            <td>{$row['prescription']}</td>
            <td>
                <button type='button' class='btn btn-primary viewMoreBtn' data-id='{$row['id']}'>
                    <i class='fa fa-arrow-right'></i>
                </button>
            </td>
        </tr>";
}

// End table
echo "</table>";

// Close database connection
pg_close($con);
?>

					


		<!-- /Main Wrapper -->
		
		<!-- jQuery -->
        <script src="assets/js/jquery-3.2.1.min.js"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
		
		<!-- Slimscroll JS -->
        <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		
		<!-- Datatables JS -->
		<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="assets/plugins/datatables/datatables.min.js"></script>
		
		<!-- Custom JS -->
		<script  src="assets/js/script.js"></script>
		
		
		
    </body>

<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/patient-list.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:52 GMT -->
</html>
