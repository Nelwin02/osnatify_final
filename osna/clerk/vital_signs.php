<!DOCTYPE html>
<html lang="en">
    
<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:20 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Manage Health</title>
		
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

// Check if clerk is logged in by verifying the session variable
if (!isset($_SESSION['clerk_username'])) { // Changed to clerk_username
    header("Location: login.php");
    exit();
}

// Retrieve the clerk's username from session
$clerk_username = $_SESSION['clerk_username']; // Updated session variable



// Fetch clerk information
$sql = "SELECT clerk_name, clerk_image FROM clerk_log WHERE username = $1"; // Using parameterized query
$result = pg_query_params($con, $sql, array($clerk_username));

if ($result) {
    $clerk = pg_fetch_assoc($result);
    if ($clerk) {
        $name = $clerk['clerk_name'];
        $image = $clerk['clerk_image'];
    } else {
        $name = "Unknown";
        $image = "default.png"; // Fallback image
    }
} else {
    $name = "Unknown";
    $image = "default.png"; // Fallback image
}

// Close the connection
pg_close($con);
?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Vital Signs</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
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
                        <span class="user-img"><img class="rounded-circle" src="../clerk/Images/<?php echo htmlspecialchars($image); ?>" width="31" alt="admin"></span>
                    </a>
                    <div class="dropdown-menu">
                        <div class="user-header">
                            <div class="avatar avatar-sm">
                            <span class="user-img"><img class="rounded-circle" src="../clerk/Images/<?php echo htmlspecialchars($image); ?>" width="31" alt="admin"></span>
                            </div>
                            <div class="user-text">
                            <h6><?php echo $clerk_username; ?></h6>
                                <p class="text-muted mb-0"><?php echo $name; ?></p>
                            </div>
                        </div>
                        <a class="dropdown-item" href="profile.php">My Profile</a>

                        <a class="dropdown-item" href="../clerk/login.php">Logout</a>
                    </div>
                </li>
                <!-- /User Menu -->
                
            </ul>
            <!-- /Header Right Menu -->
            
        </div>
        <!-- /Header -->
        
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="menu-title"> 
                            <span>Main</span>
                        </li>
                        <li class="active"> 
                            <a href="clerk_dash.php"><i class="fe fe-home"></i> <span>Dashboard</span></a>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fa fa-wheelchair"></i> <span>Manage Patient</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="add_patient.php">New Patient</a></li>
                                <li><a href="view_patient.php">Patient List</a></li>
                                
                                
                            </ul>

                            <li> 
                            <a href="consultation.php"><i class="fa fa-stethoscope"></i> <span>Consultations</span></a>
                        </li>

                       

								<li> 
                            

              
                        
                        <li> 
                            <a href="profile.php"><i class="fe fe-user-plus"></i> <span>Profile</span></a>
                        </li><br><br><br><br><br><br><br>
                        <li> 
                        <a href="login.php"><i class="fa fa-sign-out"></i> <span>Logout</span></a>
                        </li>
                </div>
            </div>
        </div>
        <!-- /Sidebar -->

    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Vital signs</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="clerk_dash.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Vital Signs</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                            <h2 class="text-center">
                                <hr style="border: 2px solid black; width: 100%;">
                            </h2>
                        </div>

                        <br><br>

            <div class="row">
    <div class="col-md-9 offset-md-2">
    <?php

include('db.php');

// Retrieve username from URL
$username = isset($_GET['username']) ? $_GET['username'] : null;

if ($username) {
    // Fetch the patient's name from the patient_info table
    $sql = "SELECT name FROM patient_info WHERE username = $1"; // Parameterized query
    $result = pg_query_params($con, $sql, array($username));

    // Check if patient data is found
    if ($result && pg_num_rows($result) > 0) {
        $patient = pg_fetch_assoc($result);
        $name = $patient['name'];
    } else {
        $name = 'Patient Not Found';  // Default if patient not found
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $username) {
    // Get form data
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $bloodpressure = $_POST['bloodpressure'];
    $heartrate = $_POST['heartrate'];

    // Insert into vitalsigns table
    $sql = "
        INSERT INTO vitalsigns (username, weight, height, bloodpressure, heartrate, status) 
        VALUES ($1, $2, $3, $4, $5, $6)
    ";
    $status = 'done'; // Default status
    $params = array($username, $weight, $height, $bloodpressure, $heartrate, $status);

    $result = pg_query_params($con, $sql, $params);

    if ($result) {
        echo "<p>Vital signs added successfully.</p>";
        echo '<div id="successModal" class="modal">
                <div class="modal-content">
                    <h4>Success!</h4>
                    <p>Vital signs saved. Ready to predict condition.</p>
                    <button onclick="window.location.href=\'consult_patient.php?username=' . urlencode($username) . '\'">OK</button>
                </div>
              </div>';
    } else {
        echo "<p>Error adding vital signs: " . pg_last_error($con) . "</p>";
    }
}

if ($username) {
?>


  

<div class="card">
    <div class="card-header bg-primary text-white text-center py-3">
        <h5 class="mb-0">Patient Vital Signs</h5>
    </div>
    <div class="card-body px-4 py-5">
        <form method="POST" action="">
            <!-- Weight and Height Input in a Row -->
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="weight" class="font-weight-semibold">Weight (kg):</label>
                        <input type="number" step="1" class="form-control" id="weight" name="weight" style="text-align: center;" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="height" class="font-weight-semibold">Height (cm):</label>
                        <input type="number" step="1" class="form-control" id="height" name="height" style="text-align: center;" required>
                    </div>
                </div>
            </div>

            <!-- Blood Pressure and Heart Rate Input in a Row -->
            <div class="row g-4 mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="bloodpressure" class="font-weight-semibold">Blood Pressure (mmHg):</label>
                        <input type="text" class="form-control" id="bloodpressure" name="bloodpressure" style="text-align: center;" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="heartrate" class="font-weight-semibold">Heart Rate (bpm):</label>
                        <input type="number" class="form-control" id="heartrate" name="heartrate" style="text-align: center;" required>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="mt-4 text-center">
                <button type="submit" class="btn btn-primary btn-lg px-5">Save</button>
                <a href="consult_patient.php?username=<?php echo urlencode($username); ?>" class="btn btn-outline-secondary btn-lg px-5 ml-3">Back</a>
            </div>
        </form>
    </div>
</div>


<?php
} else {
    echo "<p>No patient selected for adding vital signs.</p>";
}

// Close database connection
pg_close($con); // Use pg_close for PostgreSQL
?>


<style>
    .card {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.card-header {
    background: #007bff;
    color: white;
    font-size: 1.25rem;
    padding: 1rem;
    border-radius: 0.5rem 0.5rem 0 0;
}

.card-body {
    background: #f8f9fa;
    border-radius: 0 0 0.5rem 0.5rem;
}

label {
    font-size: 1rem;
    font-weight: 500;
}

input {
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    padding: 0.75rem;
    font-size: 1rem;
}

input:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

button {
    font-size: 1rem;
    padding: 0.75rem 1.5rem;
    border-radius: 0.3rem;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-outline-secondary {
    color: #6c757d;
    border-color: #6c757d;
}

.btn-outline-secondary:hover {
    background-color: #6c757d;
    color: white;
}

</style>

<style>
    /* Modal Background */
.modal {
    display: none; /* Hidden by default */
    position: fixed;
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
    padding-top: 60px;
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 30%;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}

</style>

<script>
    // Show modal when the page loads (success case)
    window.onload = function() {
        var modal = document.getElementById("successModal");
        modal.style.display = "block"; // Show the modal
    }
</script>




<script src="assets/js/jquery-3.2.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

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
</html>
