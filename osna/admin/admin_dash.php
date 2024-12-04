<?php
// Start session
session_start();
include '../db.php'; // Ensure the correct path to db.php

// Redirect to login if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: /osna/admin/login.php");
    exit();
}

$adminusername = $_SESSION['username'];

try {
    // Query counts for doctors, patients, and clerks
    $stmtDoctors = pg_prepare($con, "count_doctors", "SELECT COUNT(*) as count FROM doctor_log");
    $resultDoctors = pg_execute($con, "count_doctors", []);
    $countDoctors = ($row = pg_fetch_assoc($resultDoctors)) ? $row['count'] : 0;

    $stmtPatients = pg_prepare($con, "count_patients", "SELECT COUNT(*) as count FROM patient_info");
    $resultPatients = pg_execute($con, "count_patients", []);
    $countPatients = ($row = pg_fetch_assoc($resultPatients)) ? $row['count'] : 0;

    $stmtClerks = pg_prepare($con, "count_clerks", "SELECT COUNT(*) as count FROM clerk_log");
    $resultClerks = pg_execute($con, "count_clerks", []);
    $countClerks = ($row = pg_fetch_assoc($resultClerks)) ? $row['count'] : 0;

    // Fetch admin's name
    $stmt = pg_prepare($con, "get_admin_name", "SELECT name FROM admin_log WHERE username = $1");
    $result = pg_execute($con, "get_admin_name", [$adminusername]);
    $name = ($user = pg_fetch_assoc($result)) ? $user['name'] : "Unknown";
} catch (Exception $e) {
    $countDoctors = $countPatients = $countClerks = $name = "Error: " . htmlspecialchars($e->getMessage());
}

// Close database connection
pg_close($con);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
    <!-- Favicon -->
    <link rel="icon" href="assets/img/opd.png" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <!-- Feather Icons -->
    <link rel="stylesheet" href="assets/css/feathericon.min.css">
    <!-- Morris CSS -->
    <link rel="stylesheet" href="assets/plugins/morris/morris.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* Card styling */
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
        .card-body {
            border: 1px solid #ddd;
            border-radius: 10px;
        }
        /* Sidebar styles */
        .menu-title span {
            font-size: 14px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <a href="" class="logo"><img src="assets/img/opd.png" alt="Logo"></a>
                <a href="" class="logo logo-small"><img src="assets/img/opd.png" alt="Logo" width="30"></a>
            </div>
            <a href="#" id="toggle_btn"><i class="fe fe-text-align-left"></i></a>
            <a class="mobile_btn" id="mobile_btn"><i class="fa fa-bars"></i></a>
            <ul class="nav user-menu">
                <li class="nav-item dropdown has-arrow">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <img class="rounded-circle" src="./assets/img/profiles/profile.jpeg" alt="Admin" width="31">
                    </a>
                    <div class="dropdown-menu">
                        <div class="user-header">
                            <div class="avatar avatar-sm"><img src="./assets/img/profiles/profile.jpeg" alt="User Image"></div>
                            <div class="user-text">
                                <h6><?php echo $adminusername; ?></h6>
                                <p class="text-muted"><?php echo $name; ?></p>
                            </div>
                        </div>
                        <a class="dropdown-item" href="profile.php">My Profile</a>
                        <a class="dropdown-item" href="settings.php">Web Settings</a>
                        <a class="dropdown-item" href="./login.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="menu-title"><span>Main</span></li>
                        <li class="active"><a href="admin_dash.php"><i class="fe fe-home"></i> Dashboard</a></li>
                        <!-- More Menu Items -->
                        <li><a href="settings.php"><i class="fe fe-vector"></i> Web Settings</a></li>
                        <li><a href="profile.php"><i class="fe fe-user-plus"></i> Profile</a></li>
                        <li><a href="login.php"><i class="fa fa-sign-out"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <div class="content container-fluid">
                <!-- Page Header -->
                <div class="page-header">
                    <h3 class="page-title">Welcome, <?php echo $name; ?></h3>
                </div>
                <div class="row">
                    <!-- Patients Card -->
                    <div class="col-xl-3 col-sm-6 col-12">
                        <a href="patient.php" class="card-link">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dash-widget-header">
                                        <span class="dash-widget-icon text-success"><i class="fe fe-credit-card"></i></span>
                                        <h3><?php echo $countPatients; ?></h3>
                                    </div>
                                    <p>Total Patients</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- Doctors Card -->
                    <div class="col-xl-3 col-sm-6 col-12">
                        <a href="doctor.php" class="card-link">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dash-widget-header">
                                        <span class="dash-widget-icon text-primary"><i class="fe fe-users"></i></span>
                                        <h3><?php echo $countDoctors; ?></h3>
                                    </div>
                                    <p>Total Doctors</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- Clerks Card -->
                    <div class="col-xl-3 col-sm-6 col-12">
                        <a href="clerk.php" class="card-link">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dash-widget-header">
                                        <span class="dash-widget-icon text-warning"><i class="fe fe-folder"></i></span>
                                        <h3><?php echo $countClerks; ?></h3>
                                    </div>
                                    <p>Total Clerks</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
