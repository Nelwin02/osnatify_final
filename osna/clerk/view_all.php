<?php
session_start();
include '../db.php'; // Database connection file

// Check if clerk is logged in by verifying the session variable
if (!isset($_SESSION['clerk_username'])) { 
    header("Location: /osna/doctor2/login.php");
    exit();
}

// Retrieve the clerk's username from session
$clerk_username = $_SESSION['clerk_username']; 

// Fetch clerk information using prepared statements
$query = "SELECT clerk_name, clerk_image FROM clerk_log WHERE username = $1"; 
$stmt = pg_prepare($con, "fetch_clerk_info", $query);
$stmt = pg_execute($con, "fetch_clerk_info", array($clerk_username));

if ($stmt) {
    $clerk = pg_fetch_assoc($stmt);
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

?>

<!DOCTYPE html>
<html lang="en">
    
<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:20 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>View all list</title>
		
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
// Fetch patient information using PostgreSQL
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
  <!-- Page Wrapper -->
  <div class="page-wrapper">
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Patient List</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="consultation.php">Consultations</a></li>
                            <li class="breadcrumb-item active">Vital Signs list | Prediction List</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                            <h2 class="text-center">
                                <hr style="border: 2px solid black; width: 100%;">
                            </h2>
                        </div>

                        <?php
// consult_patient.php

// Connect to database
include('db.php');

// Retrieve username from URL
$username = isset($_GET['username']) ? $_GET['username'] : null;

if ($username) {
    // Fetch patient data from database using PostgreSQL
    $sql = "SELECT * FROM patient_info WHERE username = $1";  // Using parameterized query
    $result = pg_query_params($con, $sql, array($username));
    
    if ($result) {
        $patient = pg_fetch_assoc($result);
        
        if ($patient) {
            // Patient data is available, continue with processing
            ?>
          

        <div style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 20px;">

            <!-- Vital Signs History Table -->
            
              
                    <h3 class="mb-0" style="font-weight: 600;">Vital Signs List</h3>
                </div>
                <div class="card-body" style="background-color: #f9f9fb; padding: 20px;">
                <?php
// Fetch vital signs history from vitalsigns table using PostgreSQL
$sql = "SELECT * FROM vitalsigns WHERE username = $1 ORDER BY date_added DESC";
$result = pg_query_params($con, $sql, array($username));

// Function to format units for weight and height
function formatVitalSignUnits($value, $type) {
    if ($type == 'weight') {
        return $value . ' kg';
    } elseif ($type == 'height') {
        return $value . ' cm';
    } elseif ($type == 'bloodpressure') {
        return $value . ' mmHg';
    } elseif ($type == 'heartrate') {
        return $value . ' bpm';
    }
    return $value;
}

if ($result) {
    if (pg_num_rows($result) > 0) {
        // Display vital signs history in a scrollable table
        echo '<div class="table-responsive">';
        echo '<table class="table table-striped table-hover table-bordered" style="font-size: 14px;">';
        echo '<thead class="thead-dark"><tr><th>Weight</th><th>Height</th><th>Blood Pressure</th><th>Heart Rate</th><th>Date</th></tr></thead>';
        echo '<tbody>';
        
        while ($vitals = pg_fetch_assoc($result)) {
            echo '<tr>';
            // Format weight and height with appropriate units
            echo '<td>' . htmlspecialchars(formatVitalSignUnits($vitals['weight'], 'weight')) . '</td>';
            echo '<td>' . htmlspecialchars(formatVitalSignUnits($vitals['height'], 'height')) . '</td>';
            echo '<td>' . htmlspecialchars(formatVitalSignUnits($vitals['bloodpressure'], 'bloodpressure')) . '</td>';
            echo '<td>' . htmlspecialchars(formatVitalSignUnits($vitals['heartrate'], 'heartrate')) . '</td>';
            echo '<td>' . htmlspecialchars($vitals['date_added']) . '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
        echo '</div>';
    } else {
        echo "<p class='text-center text-muted'>No vital signs history available.</p>";
    }
} else {
    echo "Error fetching vital signs history: " . pg_last_error($con);
}
?>


          
                    <h3 class="mb-0" style="font-weight: 600;">Prediction List</h3>
                </div>
                <div class="card-body" style="background-color: #f9f9fb; padding: 20px; font-size: 14px;">
                <?php
// Fetch prediction history from prediction table using PostgreSQL
$sql = "SELECT * FROM prediction WHERE username = $1 ORDER BY created_at DESC";
$result = pg_query_params($con, $sql, array($username));

// Function to sanitize text (removes unwanted keywords)
function sanitizeText($text) {
    $keywords = ['Diagnosis:', 'Prescription:', 'Treatment:'];
    return str_replace($keywords, "", $text);
}

if ($result) {
    if (pg_num_rows($result) > 0) {
        // Display prediction history in a scrollable table
        echo '<div class="table-responsive">';
        echo '<table class="table table-striped table-hover table-bordered" style="font-size: 14px;">';
        echo '<thead class="thead-dark"><tr><th>Symptoms</th><th>Diagnosis</th><th>Prescription</th><th>Treatment</th></tr></thead>';
        echo '<tbody>';
        
        while ($prediction = pg_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars(sanitizeText($prediction['symptoms'])) . '</td>';
            echo '<td>' . htmlspecialchars(sanitizeText($prediction['predicted_disease'])) . '</td>';
            echo '<td>' . htmlspecialchars(sanitizeText($prediction['predicted_prescription'])) . '</td>';
            echo '<td>' . htmlspecialchars(sanitizeText($prediction['predicted_treatment'])) . '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
        echo '</div>';
    } else {
        echo "<p class='text-center text-muted'>No prediction history available.</p>";
    }
} else {
    echo "Error fetching prediction history: " . pg_last_error($con);
}
?>

                </div>
            </div>
        </div>

         <!-- Your HTML and PHP code to display patient info goes here -->
         <?php
        } else {
            echo "No patient found with the username: $username";
        }
    } else {
        echo "Error fetching patient data: " . pg_last_error($con);
    }
}
?>





<style>
    .container {
    background-color: #f8f9fa; /* Light background for better contrast */
    padding: 20px;
    border-radius: 10px; /* Rounded corners for a softer look */
}

.list-group-item {
    border: none; /* Remove border from list items */
    background-color: transparent; /* Transparent background */
}

.list-group-item a {
    text-decoration: none; /* Remove underline from links */
    color: #333; /* Dark text color for better readability */
}

.list-group-item a:hover {
    background-color: #e9ecef; /* Light gray on hover */
    border-radius: 5px; /* Rounded hover effect */
}

.btn {
    transition: background-color 0.3s, transform 0.3s; /* Add transition for smooth effect */
}

.btn:hover {
    background-color: #218838; /* Darker green on hover */
    transform: scale(1.05); /* Slightly enlarge the button */
}

</style>

 <!-- for displaying patient data  -->
   

    <!-- jQuery -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
