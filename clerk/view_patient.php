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

        <?php
session_start();
include 'db.php'; 

// Check if clerk is logged in by verifying the session variable
if (!isset($_SESSION['clerk_username'])) {
    header("Location: login.php");
    exit();
}

// Retrieve the clerk's username from session
$clerk_username = $_SESSION['clerk_username']; // Updated session variable

// Fetch clerk information using a parameterized query
$sql = "SELECT clerk_name, clerk_image FROM clerk_log WHERE username = $1"; // Using placeholder for username
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
?>


<?php

$sql = "
    SELECT 
        patient_info.username, 
        patient_info.name, 
        patient_info.address, 
        patient_info.contactnum, 
        patient_info.age, 
        patient_info.sex, 
        patient_info.date_created, 
        COALESCE(vitalsigns.status, 'No Record') AS vitalsigns_status, 
        COALESCE(prediction.status, 'No Record') AS prediction_status
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

// Check if the "today" filter is applied
if (isset($_POST['dateFilter']) && $_POST['dateFilter'] === 'today') {
    $sql .= " WHERE DATE(patient_info.date_created) = CURRENT_DATE ";
} else {
    $sql .= " ORDER BY patient_info.id DESC ";
}

// Execute the query using pg_query
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
                            <li class="breadcrumb-item"><a href="clerk_dash.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">search | view all</li>
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

            <style>
        /* Add custom styles for pagination */
        .pagination-container {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
    
   

        <!-- Consultations Table -->
        <div class="card shadow-sm">
            <div class="card-body">

        <div class="row align-items-center mb-4">
            <!-- Search Input -->
            <div class="col-md-12 d-flex justify-content-end">
                <div class="form-group mb-0 w-25">
                <style>
    .search-container {
      position: relative;
      width: 100%;
    }
    .search-container input {
      width: 100%;
      padding-left: 30px; /* Space for the icon */
      text-align: center;
      padding-right: 10px; /* Optional: for space on the right side */
    }
    .search-container i {
      position: absolute;
      left: 10px;
      top: 50%;
      transform: translateY(-50%);
      color: #888; /* Placeholder color */
    }
    .search-container input::placeholder {
      text-align: center; /* Center the placeholder text */
      color: #888; /* Optional: Change placeholder color */
    }
  </style>
</head>
<body>

  <div class="search-container">
    <i class="fa fa-search"></i>
    <input type="text" id="searchInput" class="form-control placeholder-center" placeholder="Search for P_ID, Name, or Address">
  </div>
                </div>
            </div>
        </div>
                <table class="table table-bordered table-hover" id="patientTable">
                    <thead class="thead-dark">
                        <tr>
                            <th style="font-size: 13px;">P_ID</th>
                            <th style="font-size: 13px;">Name</th>
                            <th style="font-size: 13px;">Address</th>
                            <th style="font-size: 13px;">Age</th>
                            <th style="font-size: 13px;">Sex</th>
                            <th style="font-size: 13px;">Date Created</th>
                            <th style="font-size: 13px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                       <!-- PHP loop to populate rows (dynamically generated content) -->
                        <?php
                        // Assuming the connection to PostgreSQL is established using pg_connect
                        if ($result && pg_num_rows($result) > 0) {
                            while ($row = pg_fetch_assoc($result)) {
                                echo "<tr data-date='" . htmlspecialchars($row['date_created']) . "'>
                                    <td style='font-size: 14px;'>" . htmlspecialchars($row['username']) . "</td>
                                    <td style='font-size: 14px;'>" . htmlspecialchars($row['name']) . "</td>
                                    <td style='font-size: 14px;'>" . htmlspecialchars($row['address']) . "</td>
                                    <td style='font-size: 14px;'>" . htmlspecialchars($row['age']) . "</td>
                                    <td style='font-size: 14px;'>" . htmlspecialchars($row['sex']) . "</td>
                                    <td style='font-size: 14px;'>" . htmlspecialchars($row['date_created']) . "</td>
                                    <td style='font-size: 12px;'>
                                        <a href='view_all.php?username=" . urlencode($row['username']) . "' class='btn btn-info btn-sm' title='View'>view all</a>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center'>No patients found.</td></tr>";
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
          <!-- Pagination Controls -->
          <div class="pagination-container">
            <button id="prevBtn" class="btn btn-secondary" onclick="changePage(-1)">Previous</button>
            <span id="pageNumber">Page 1</span>
            <button id="nextBtn" class="btn btn-secondary" onclick="changePage(1)">Next</button>
            <select id="recordsPerPage" class="form-control w-auto" onchange="setRecordsPerPage()">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="all">All</option>
            </select>
        </div>
        <br>

       
    </div>

    <script>
      document.addEventListener("DOMContentLoaded", function () {
    let currentPage = 1;
    let rowsPerPage = 5;
    const tableBody = document.getElementById("tableBody");
    const searchInput = document.getElementById("searchInput");
    const pageNumber = document.getElementById("pageNumber");
    const recordsPerPage = document.getElementById("recordsPerPage");

    // Store all rows in an array
    const rows = Array.from(tableBody.getElementsByTagName("tr"));
    const totalRows = rows.length;

    // Function to show only the rows for the current page
    function displayRows() {
        const startIndex = (currentPage - 1) * rowsPerPage;
        const endIndex = startIndex + rowsPerPage;
        const filteredRows = rows.slice(startIndex, endIndex);

        // Clear table and re-render rows
        tableBody.innerHTML = "";
        filteredRows.forEach(row => tableBody.appendChild(row));

        // Update page number display
        pageNumber.innerText = `Page ${currentPage}`;

        // Update the visibility of Next and Previous buttons
        document.getElementById("prevBtn").style.display = (currentPage > 1) ? "inline-block" : "none";
        document.getElementById("nextBtn").style.display = (currentPage * rowsPerPage < totalRows) ? "inline-block" : "none";
    }

    // Function to change the page (Next/Previous)
    function changePage(direction) {
        const newPage = currentPage + direction;
        if (newPage > 0 && newPage <= Math.ceil(totalRows / rowsPerPage)) {
            currentPage = newPage;
            displayRows();
        }
    }

    // Function to set records per page
    function setRecordsPerPage() {
        if (recordsPerPage.value === "all") {
            rowsPerPage = totalRows;
        } else {
            rowsPerPage = parseInt(recordsPerPage.value);
        }
        currentPage = 1;  // Reset to first page
        displayRows();
    }

    // Search functionality
    searchInput.addEventListener("input", function () {
        const query = searchInput.value.toLowerCase();

        // Filter rows based on search query
        rows.forEach(row => {
            const username = row.cells[0].textContent.toLowerCase();
            const name = row.cells[1].textContent.toLowerCase();
            const address = row.cells[2].textContent.toLowerCase();

            if (username.includes(query) || name.includes(query) || address.includes(query)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });

        // After filtering, reset pagination and show filtered rows
        currentPage = 1;
        displayRows();
    });

    // Initial setup to show rows and handle page changes
    displayRows();

    // Event listeners for Next and Previous buttons
    document.getElementById("prevBtn").addEventListener("click", function() {
        changePage(-1);
    });

    document.getElementById("nextBtn").addEventListener("click", function() {
        changePage(1);
    });

    // Event listener for records per page dropdown
    recordsPerPage.addEventListener("change", setRecordsPerPage);
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
