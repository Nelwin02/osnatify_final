   <?php
// Start session
session_start();

// Include the database connection
include '../db.php'; // Ensure correct path

// Redirect to login if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: /osna/clerk/login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
    
<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:20 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>clerk</title>
	
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
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
		<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

		
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->

	<?php
// Retrieve the clerk's username from the session
$clerk_username = $_SESSION['clerk_username'] ?? null;

if ($clerk_username) {
    // Fetch clerk information
    $query = "SELECT clerk_name, clerk_image FROM clerk_log WHERE username = $1";
    $stmt = pg_prepare($con, "fetch_clerk_info", $query);
    $stmt = pg_execute($con, "fetch_clerk_info", array($clerk_username));

    if ($stmt) {
        $clerk = pg_fetch_assoc($stmt);
        $name = $clerk['clerk_name'] ?? "Unknown";
        $image = $clerk['clerk_image'] ?? "default.png"; // Fallback image
    } else {
        $name = "Unknown";
        $image = "default.png";
    }
} else {
    $name = "Unknown";
    $image = "default.png";
}

// Query to count patients
$queryPatients = "SELECT COUNT(*) as count FROM patient_info";
$resultPatients = pg_query($con, $queryPatients);
$countPatients = pg_fetch_assoc($resultPatients)['count'] ?? 0;

// Define a maximum threshold for progress calculation
$maxPatients = 1000; // Change this to your desired maximum for the progress bar.
$progressPercentage = ($countPatients / $maxPatients) * 100;
$progressPercentage = min($progressPercentage, 100); // Cap at 100%

// Get total patients for today
$queryToday = "SELECT COUNT(*) as count FROM patient_info WHERE DATE(date_created) = CURRENT_DATE";
$resultToday = pg_query($con, $queryToday);
$todayCount = pg_fetch_assoc($resultToday)['count'] ?? 0;

// Get total patients for this month
$queryMonth = "SELECT COUNT(*) as count FROM patient_info WHERE EXTRACT(MONTH FROM date_created) = EXTRACT(MONTH FROM CURRENT_DATE) AND EXTRACT(YEAR FROM date_created) = EXTRACT(YEAR FROM CURRENT_DATE)";
$resultMonth = pg_query($con, $queryMonth);
$monthCount = pg_fetch_assoc($resultMonth)['count'] ?? 0;

// Get total patients for this year
$queryYear = "SELECT COUNT(*) as count FROM patient_info WHERE EXTRACT(YEAR FROM date_created) = EXTRACT(YEAR FROM CURRENT_DATE)";
$resultYear = pg_query($con, $queryYear);
$yearCount = pg_fetch_assoc($resultYear)['count'] ?? 0;

// Array to hold monthly counts
$monthlyCounts = [];

// Get total patients for each month of the current year
for ($month = 1; $month <= 12; $month++) {
    $queryMonth = "SELECT COUNT(*) as count FROM patient_info 
                   WHERE EXTRACT(MONTH FROM date_created) = $1 
                   AND EXTRACT(YEAR FROM date_created) = EXTRACT(YEAR FROM CURRENT_DATE)";
    $stmtMonth = pg_prepare($con, "fetch_monthly_count_$month", $queryMonth);
    $resultMonth = pg_execute($con, "fetch_monthly_count_$month", array($month));
    $monthlyCounts[] = (int)(pg_fetch_assoc($resultMonth)['count'] ?? 0);
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
							<span class="user-img"><img class="rounded-circle" src="../clerk/Images/<?php echo htmlspecialchars($image); ?>" width="31" alt="clerk"></span>
						</a>
						<div class="dropdown-menu">
							<div class="user-header">
								<div class="avatar avatar-sm">
								<span class="user-img"><img class="rounded-circle" src="../clerk/Images/<?php echo htmlspecialchars($image); ?>" width="31" alt="clerk"></span>
								</div>
								<div class="user-text">
								<h6><?php echo htmlspecialchars($clerk_username); ?></h6>
									<p class="text-muted mb-0"><?php echo htmlspecialchars($name); ?></p>
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
								<h3 class="page-title">Welcome, <?php echo $name; ?></h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item active">Dashboard</li>
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
					<!-- /Page Header -->
					
					<div class="row justify-content-center row-sm">
					
    <!-- Left Section: Total Patients Card -->
    <div class="col-xl-3 col-sm-9 col-12">
        <div class="card">
            <div class="card-body">
                <div class="dash-widget-header">
                    <span class="dash-widget-icon text-primary border-primary">
                        <i class="fe fe-users"></i>
                    </span>
                    <div class="dash-count">
                        <p><?php echo $countPatients; ?></p>
                    </div>
                </div>
                <div class="dash-widget-info">
                    <h6 class="text-muted">Total Patients</h6>
                    <div class="progress progress-sm">
                        <div 
                            class="progress-bar bg-warning" 
                            id="patientProgressBar" 
                            style="width: <?php echo $progressPercentage; ?>%;" 
                            data-count="<?php echo $countPatients; ?>">
                        </div>
                    </div>
                    <small class="text-muted"><?php echo round($progressPercentage); ?>%</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Section: Line Graph -->
    <div class="col-xl-9 col-sm-9 col-12">
        <div class="card">
            <div class="card-body">
                <h5>Total Patients Overview</h5>
                <canvas id="patientLineChart"></canvas>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>
    const monthlyData = [<?php echo implode(',', $monthlyCounts); ?>]; // Monthly data from PHP

    const data = {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'], // X-axis labels
        datasets: [{
            label: 'Patients Per Month (This Year)',
            data: monthlyData, // Data for each month
            backgroundColor: 'rgba(75, 192, 192, 0.6)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1,
        }]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                tooltip: {
                    enabled: true,
                },
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Month'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Number of Patients'
                    },
                    beginAtZero: true,
                }
            }
        }
    };

    const ctx = document.getElementById('patientLineChart').getContext('2d');
    new Chart(ctx, config);
</script>



						
						


					
					
		
        </div>
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
