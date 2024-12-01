<!DOCTYPE html>
<html lang="en">
    
<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:20 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Consultation</title>
		
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
include 'db.php'; // Assuming db.php contains PostgreSQL connection details
?>

<?php
// Check if clerk is logged in by verifying the session variable
if (!isset($_SESSION['clerk_username'])) { // Check if session variable 'clerk_username' is set
    header("Location: login.php");
    exit();
}

// Retrieve the clerk's username from session
$clerk_username = $_SESSION['clerk_username']; // Get the username from session

// Fetch clerk information using PostgreSQL
$sql = "SELECT clerk_name, clerk_image FROM clerk_log WHERE username = $1"; // Use $1 placeholder for parameter binding

// Prepare and execute the query
$result = pg_prepare($con, "get_clerk_info", $sql); // Prepare the query
$result = pg_execute($con, "get_clerk_info", array($clerk_username)); // Execute with the username as parameter

if ($result) {
    $clerk = pg_fetch_assoc($result); // Fetch the result as an associative array
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

<?php
// Build the SQL query
$sql = "
    SELECT 
        patient_info.username, 
        patient_info.name, 
        patient_info.address, 
        patient_info.contactnum, 
        patient_info.age, 
        patient_info.sex, 
        patient_info.date_created, 
        COALESCE(MAX(vitalsigns.status), 'No Record') AS vitalsigns_status, 
        COALESCE(MAX(prediction.status), 'No Record') AS prediction_status
    FROM 
        patient_info
    LEFT JOIN 
        vitalsigns 
    ON 
        patient_info.username = vitalsigns.username
    LEFT JOIN 
        prediction 
    ON 
        patient_info.username = prediction.username
";

// Apply filter for "today" if selected
if (isset($_POST['dateFilter']) && $_POST['dateFilter'] === 'today') {
    $sql .= " WHERE patient_info.date_created::date = CURRENT_DATE ";
}

// Add grouping and ordering
$sql .= "
    GROUP BY 
        patient_info.username, 
        patient_info.name, 
        patient_info.address, 
        patient_info.contactnum, 
        patient_info.age, 
        patient_info.sex, 
        patient_info.date_created,
        patient_info.id
    ORDER BY 
        patient_info.id DESC
";


// Execute the query
$result = pg_query($con, $sql);

// Handle query errors
if (!$result) {
    die("Query Failed: " . pg_last_error($con));
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
                        <h3 class="page-title">Consultations</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="clerk_dash.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Consultations</li>
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

            <div class="row align-items-center mb-4">
    <!-- Align Date Filter and Search Input to the right -->
    <div class="col-md-12 d-flex justify-content-end">
        <!-- Date Filter -->
        <div class="form-group mb-0 mr-3 w-25">
    <label for="dateFilter" class="font-weight-bold mr-2" style="color: grey">Date Filter</label><br>
    <select id="dateFilter" class="form-control d-inline-block mt-1" style="width: 100%;"> 
        <option value="today" selected>Today</option>
        <option value="all">All</option>
    </select>
</div>


        <!-- Search Input -->
        <div class="form-group mb-0 w-25" style="position: relative;">
        
        <label for="searchInput" class="font-weight-bold mr-2" style="color: grey;">Search P_ID or Name</label>
        <i class="fa fa-search" style="position: absolute; top: 65%; left: 10px; transform: translateY(-50%); color: gray;"></i>
        <input type="text" 
                id="searchInput" 
                class="form-control placeholder-center" 
                placeholder="Choose 'All Date filter' if not found" 
                style="text-align: center; padding-left: 30px;">
        </div>

            </div>
        </div>
<!-- Consultations Table -->
<div class="card shadow-sm">
    <div class="card-body">
        <h4 class="header-title mb-4">Patient Consultations</h4>
        <table class="table table-bordered table-hover" id="patientTable">
            <thead class="thead-dark">
                <tr>
                    <th style="font-size: 13px;">P_ID</th>
                    <th style="font-size: 13px;">Name</th>
                    <th style="font-size: 13px;">Address</th>
                    <th style="font-size: 13px;">Age</th>
                    <th style="font-size: 13px;">Sex</th>
                    <th style="font-size: 13px;">Date Created</th>
                    <th style="font-size: 13px;">Vital Signs</th>
                    <th style="font-size: 13px;">Prediction</th>
                    <th style="font-size: 13px;">Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody">
               <!-- PHP loop to populate rows -->
<?php
if ($result && pg_num_rows($result) > 0) {
    while ($row = pg_fetch_assoc($result)) {
        // Determine icons based on the statuses
        $vitalsignsIcon = $row['vitalsigns_status'] === 'done' 
            ? "<span class='text-success'><i class='fa fa-check-circle'></i></span>" 
            : ($row['vitalsigns_status'] === 'pending'
                ? "<span class='text-warning'><i class='fa fa-exclamation-circle'></i></span>"
                : "<span class='text-muted'>No Record</span>");

        $predictionIcon = $row['prediction_status'] === 'done' 
            ? "<span class='text-success'><i class='fa fa-check-circle'></i></span>" 
            : ($row['prediction_status'] === 'pending'
                ? "<span class='text-warning'><i class='fa fa-exclamation-circle'></i></span>"
                : "<span class='text-muted'>No Record</span>");

        echo "<tr data-date='" . htmlspecialchars($row['date_created']) . "'>
                <td style='font-size: 14px;'>" . htmlspecialchars($row['username']) . "</td>
                <td style='font-size: 14px;'>" . htmlspecialchars($row['name']) . "</td>
                <td style='font-size: 14px;'>" . htmlspecialchars($row['address']) . "</td>
                <td style='font-size: 14px;'>" . htmlspecialchars($row['age']) . "</td>
                <td style='font-size: 14px;'>" . htmlspecialchars($row['sex']) . "</td>
                <td style='font-size: 14px;'>" . htmlspecialchars($row['date_created']) . "</td>
                <td class='text-center' style='font-size: 13px;'>" . $vitalsignsIcon . "</td>
                <td class='text-center' style='font-size: 13px;'>" . $predictionIcon . "</td>
                <td style='font-size: 12px;'>
                    <a href='consult_patient.php?username=" . urlencode($row['username']) . "' class='btn btn-info btn-sm' title='View'><i class='fa fa-eye'></i></a>
                    <a href='edit_patient.php?username=" . urlencode($row['username']) . "' class='btn btn-warning btn-sm' title='Edit'><i class='fa fa-pencil'></i></a>
                </td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='9' class='text-center'>No patients found.</td></tr>";
}
?>

            </tbody>
        </table>
    </div>
</div>

<!-- JavaScript to Filter Table Rows Based on Date -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const dateFilter = document.getElementById('dateFilter');
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('tableBody');
    const rows = tableBody.getElementsByTagName('tr');

    function filterRows() {
        const selectedValue = dateFilter.value;
        const searchQuery = searchInput.value.toLowerCase();
        const today = new Date();
        today.setHours(0, 0, 0, 0); // Reset time for today

        Array.from(rows).forEach((row) => {
            const dateCreated = new Date(row.getAttribute('data-date'));
            dateCreated.setHours(0, 0, 0, 0); // Reset time for the stored date
            const name = row.cells[1].textContent.toLowerCase();
            const username = row.cells[0].textContent.toLowerCase();
            const address = row.cells[2].textContent.toLowerCase(); // Assuming the address is in the 3rd column

            let showRow = false;

            // Date filter logic
            if (selectedValue === 'today') {
                showRow = dateCreated.getTime() === today.getTime();
            } else if (selectedValue === 'all') {
                showRow = true;
            }

            // Combine date filter logic with search filter logic (including address)
            if (showRow && (name.includes(searchQuery) || username.includes(searchQuery) || address.includes(searchQuery))) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Apply initial filtering on page load
    filterRows();

    // Add event listeners for date filter and search input
    dateFilter.addEventListener('change', filterRows);
    searchInput.addEventListener('keyup', filterRows);
});

</script>





<style>

.placeholder-center::placeholder {
    text-align: center;
}

    .thead-dark th {
        background-color: #343a40;
        color: #ffffff;
    }
    #toggleRowsBtn {
        min-width: 100px;
    }
</style>



    <!-- /Page Wrapper -->

    <!-- jQuery -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
