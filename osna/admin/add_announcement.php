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
include 'db.php'; // Ensure this connects to your PostgreSQL database
?>

<?php
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

try {
    // Fetch doctor's name and image
    $stmt = pg_prepare(
        $con,
        "get_doctor_log",
        "SELECT doctor_name, doctor_image FROM doctor_log WHERE username = $1"
    );
    $result = pg_execute($con, "get_doctor_log", array($username));

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
} catch (Exception $e) {
    $name = "Error: " . htmlspecialchars($e->getMessage());
}
?>

<?php
// Handle Add Announcement
if (isset($_POST['add_announcement'])) {
    $title = htmlspecialchars($_POST['title']);
    $message = htmlspecialchars($_POST['message']);

    try {
        // Insert into the announcement table
        $stmt = pg_prepare(
            $con,
            "add_announcement",
            "INSERT INTO announcement (title, message) VALUES ($1, $2)"
        );
        $result = pg_execute($con, "add_announcement", array($title, $message));

        if ($result) {
            echo "Announcement added successfully!";
        } else {
            echo "Error adding announcement.";
        }
    } catch (Exception $e) {
        echo "Error: " . htmlspecialchars($e->getMessage());
    }
}

// Handle Edit Announcement
if (isset($_POST['edit_announcement'])) {
    $announcement_id = $_POST['announcement_id'];
    $title = htmlspecialchars($_POST['title']);
    $message = htmlspecialchars($_POST['message']);

    try {
        // Update the announcement in the database
        $stmt = pg_prepare(
            $con,
            "edit_announcement",
            "UPDATE announcement SET title = $1, message = $2 WHERE id = $3"
        );
        $result = pg_execute($con, "edit_announcement", array($title, $message, $announcement_id));

        if ($result) {
            echo "Announcement updated successfully!";
        } else {
            echo "Error updating announcement.";
        }
    } catch (Exception $e) {
        echo "Error: " . htmlspecialchars($e->getMessage());
    }
}

// Handle Delete Announcement
if (isset($_GET['delete'])) {
    $announcement_id = $_GET['delete'];

    try {
        // Delete the announcement
        $stmt = pg_prepare(
            $con,
            "delete_announcement",
            "DELETE FROM announcement WHERE id = $1"
        );
        $result = pg_execute($con, "delete_announcement", array($announcement_id));

        if ($result) {
            echo "Announcement deleted successfully!";
        } else {
            echo "Error deleting announcement.";
        }
    } catch (Exception $e) {
        echo "Error: " . htmlspecialchars($e->getMessage());
    }
}

// Fetch all announcements
try {
    $stmt = pg_prepare($con, "fetch_announcements", "SELECT * FROM announcement ORDER BY date DESC");
    $result = pg_execute($con, "fetch_announcements", array());

    if (!$result) {
        echo "Error fetching announcements.";
    }
} catch (Exception $e) {
    echo "Error: " . htmlspecialchars($e->getMessage());
}
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
                                    <li class="breadcrumb-item"><a href="clerk_dash.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Add Announcement</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                            <h2 class="text-center">
                                <hr style="border: 2px solid black; width: 100%;">
                            </h2>
                        </div>

 
<!-- Add Announcement Form -->
<div class="content container-fluid">
<div class="container mt-">
    <h2>Add New Announcement</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" name="title" id="title" required>
        </div>
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea class="form-control" name="message" id="message" rows="4" required></textarea>
        </div>
        <button type="submit" name="add_announcement" class="btn btn-primary">Save</button>
    </form>
</div>

<!-- Display Announcements -->
<div class="container mt-5">
    <h2>All Announcements</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Message</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = pg_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo htmlspecialchars($row['title']); ?></td>
        <td><?php echo htmlspecialchars($row['message']); ?></td>
        <td><?php echo htmlspecialchars($row['date']); ?></td>
        <td>
            <!-- Edit Button with Icon -->
            <a href="edit_announcement.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> <!-- Font Awesome Edit Icon -->
            </a>
            
            <!-- Delete Button with Icon -->
            <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this announcement?')">
                <i class="fas fa-trash-alt"></i> <!-- Font Awesome Trash Icon -->
            </a>
        </td>
    </tr>
<?php } ?>


        </tbody>
    </table>
</div>




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