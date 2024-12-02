<!DOCTYPE html>
<html lang="en">
    
<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:20 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Add Announcement</title>
		
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
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
		
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->

        <?php
session_start();
include 'db.php';

// Ensure user is authenticated
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch doctor details
$query = "SELECT doctor_name, doctor_image FROM doctor_log WHERE username = $1";
$result = pg_query_params($con, $query, [$username]);

if ($result) {
    $user = pg_fetch_assoc($result);
    if ($user) {
        $name = $user['doctor_name'];
        $image = $user['doctor_image'];
    } else {
        $name = "Unknown";
        $image = null;
    }
} else {
    $name = "Unknown";
    $image = null;
    echo "Error: " . pg_last_error($con);
}

// Fetch announcement details
if (isset($_GET['id'])) {
    $announcement_id = $_GET['id'];
    $query = "SELECT * FROM announcement WHERE id = $1";
    $result = pg_query_params($con, $query, [$announcement_id]);

    if ($result && pg_num_rows($result) > 0) {
        $announcement = pg_fetch_assoc($result);
    } else {
        echo "Announcement not found!";
        exit();
    }
} else {
    echo "No announcement ID provided!";
    exit();
}

// Handle form submission for editing the announcement
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_announcement'])) {
    $title = $_POST['title'];
    $message = $_POST['message'];

    $query = "UPDATE announcement SET title = $1, message = $2 WHERE id = $3";
    $result = pg_query_params($con, $query, [$title, $message, $announcement_id]);

    if ($result) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('successModal').style.display = 'block';
            });
        </script>";
    } else {
        echo "Error updating announcement: " . pg_last_error($con);
    }
}
?>

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
                                <p class="text-muted mb-0"><?php echo $name; ?></p>
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
                    <div class="page-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="page-title">Announcement</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="admin_dash.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Edit Announcement</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                            <h2 class="text-center">
                                <hr style="border: 2px solid black; width: 100%;">
                            </h2>
                        </div>
    <style>
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }
        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 30%;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .close-btn {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .close-btn:hover {
            background-color: #218838;
        }
    </style>

       <!-- Success Modal -->
       <div id="successModal" class="modal">
        <div class="modal-content">
            <p>Announcement updated successfully!</p>
            <button class="close-btn" onclick="closeModal()">Close</button>
        </div>
    </div>

    <script>
        function closeModal() {
            document.getElementById('successModal').style.display = 'none';
            window.location.href = 'add_announcement.php'; // Redirect after closing
        }
    </script>

   

   
            
            <!-- Edit Announcement Form -->
            <div class="container">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" name="title" id="title" value="<?php echo htmlspecialchars($announcement['title']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message:</label>
                        <textarea class="form-control" name="message" id="message" rows="4" required><?php echo htmlspecialchars($announcement['message']); ?></textarea>
                    </div>
                    <button type="submit" name="update_announcement" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
    <!-- /Page Wrapper -->

</div>
<!-- /Main Wrapper -->


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
