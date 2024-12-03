<!DOCTYPE html>
<html lang="en">
    
<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:20 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Print Prescription</title>
		
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
?>

<?php
				if (!isset($_SESSION['username'])) {
					
					header("Location: login.php");
					exit();
				}
				
				$username = $_SESSION['username'];
				
				// Prepare SQL query using PostgreSQL
				$sql = "SELECT doctor_name, doctor_image FROM doctor_log WHERE username = $1";
				$stmt = pg_prepare($con, "get_doctor_details", $sql);
				$result = pg_execute($con, "get_doctor_details", array($username));

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
?>

<?php

// Fetch patient information
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
						<span class="user-img">
					
						<img src="images/<?php echo htmlspecialchars($image); ?>" alt="Doctor Image" class="img-circle" />
					</span>

					<style>
						.user-img img.img-circle {
							width: 50px;        
							height: 50px;       
							border-radius: 50%; 
							object-fit: cover;  
						}

					</style>


						</a>
						<div class="dropdown-menu">
							<div class="user-header">
								<div class="avatar avatar-sm">
								<img src="images/<?php echo htmlspecialchars($image); ?>" alt="Doctor Image" class="img-circle" />
								</div>
								<div class="user-text">
								<h6><?php echo $username; ?></h6>
									<p class="text-muted mb-0" style="font-size: 13px;"><?php echo $name; ?></p>
								</div>
							</div>
							<a class="dropdown-item" href="profile.php">My Profile</a>
							<a class="dropdown-item" href="settings.php">Settings</a>
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
					margin-right: 8px;
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
								<a href="doctor_dash2.php"><i class="fe fe-home"></i> <span>Dashboard</span></a>
							</li>
							<li class="submenu">
								<a href="#"><i class="fa fa-wheelchair"></i> <span>Prescription</span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
								<li><a href="prescription.php"><i class="fa fa-plus"></i> &nbsp;Add Prescription</a></li>
								
								</ul>

								<li><a href="patient_list.php"><i class="fa fa-info-circle"></i> &nbsp; Patient List</a></li>
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
                                <h3 class="page-title">Prescription</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="doctor_dash2.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Print Prescription</li>
                                </ul>
                            </div>
                        </div>
                    </div>
            
                    <div class="printtable" style="max-width: 100%; margin-top: 20px;">

                    <!-- Print Button -->
                    <div class="text-left mb-3">
                        <button onclick="printPrescription()" class="btn btn-primary">Print</button>
                 
                    
    <button onclick="back()" class="btn btn-primary">Back</button>
</div>

<script>
    function back() {
        window.history.back(); // This will navigate the user to the previous page
    }
</script>

<?php

include('db.php');

// Retrieve username from URL
$username = isset($_GET['username']) ? $_GET['username'] : null;
$success = isset($_GET['success']) ? $_GET['success'] : null;

if ($username) {
    // Fetch patient data from database
    $sql = "SELECT * FROM patient_info WHERE username = $1";
    $stmt = pg_prepare($con, "patient_query", $sql);  // Prepare the query
    $result = pg_execute($con, "patient_query", array($username));  // Execute the query
    $patient = pg_fetch_assoc($result);  // Fetch the result as an associative array

    // Fetch doctor confirmation data from database
    $sql = "SELECT * FROM doctor_confirm WHERE username = $1";
    $stmt = pg_prepare($con, "doctor_confirm_query", $sql);  // Prepare the query
    $result = pg_execute($con, "doctor_confirm_query", array($username));  // Execute the query
    $doctorConfirm = pg_fetch_assoc($result);  // Fetch the result

    // Fetch prediction data from database
    $sql = "SELECT * FROM prediction WHERE username = $1 order by created_at desc";
    $stmt = pg_prepare($con, "prediction_query", $sql);  // Prepare the query
    $result = pg_execute($con, "prediction_query", array($username));  // Execute the query
    $prediction = pg_fetch_assoc($result);  // Fetch the result

    if ($patient) {
        ?>
                    <div style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                    <!-- Top Buttons Row -->
                    <div class="d-flex mb-4">
  


                        <style>
                        .blue-link {
                            color: #007BFF; /* Primary blue */
                            text-decoration: none;
                            font-size: 16px;
                            font-weight: bold;
                            border: 2px solid #007BFF; /* Blue border */
                            border-radius: 5px; /* Rounded corners */
                            padding: 5px 10px; /* Space inside the border */
                            display: inline-block; /* Ensure the border wraps the content */
                            transition: background-color 0.3s, color 0.3s; /* Smooth transition for hover */
                        }

                        .blue-link i {
                            color: #0056b3; /* Darker blue for the icon */
                            font-size: 18px;
                            margin-right: 5px; /* Space between the icon and text */
                        }

                        .blue-link:hover {
                            color: #ffffff; /* Change text color on hover */
                            background-color: #007BFF; /* Fill background on hover */
                        }

                        .blue-link i:hover {
                            color: #ffffff; /* Change icon color on hover */
                        }

                        </style>


                                        <!-- Predict Diagnosis Button -->
                                    
                                    </div>
                                    <div class="row">
                                    



                        
                                    <div class="card-body" style="background-color: #f9f9f9; padding: 30px;">
                                    <?php
// Assuming $username is set based on the logged-in user

// Fetch vitals data from vitalsigns table
$sql = "SELECT weight, height, bloodpressure, heartrate FROM vitalsigns WHERE username = $1 order by date_added desc";
$stmt = pg_prepare($con, "vitals_query", $sql);
$result = pg_execute($con, "vitals_query", array($username));
$vitalsData = pg_num_rows($result) > 0 ? pg_fetch_assoc($result) : null;

// Fetch predicted treatment from patient_info
$sql = "SELECT predicted_treatment FROM prediction WHERE username = $1 order by created_at desc";
$stmt = pg_prepare($con, "treatment_query", $sql);
$result = pg_execute($con, "treatment_query", array($username));
$predictedTreatment = pg_num_rows($result) > 0 ? pg_fetch_assoc($result)['predicted_treatment'] : 'N/A';

// Fetch symptoms from prediction
$sql = "SELECT symptoms FROM prediction WHERE username = $1 order by created_at desc";
$stmt = pg_prepare($con, "symptoms_query", $sql);
$result = pg_execute($con, "symptoms_query", array($username));
$symptoms = pg_num_rows($result) > 0 ? pg_fetch_assoc($result)['symptoms'] : 'N/A';

// Get today's date
$todayDate = date("F j, Y");

// Fetch prescription history from doctor_confirm table where date_created is today
$sql = "SELECT * FROM doctor_confirm WHERE username = $1 AND date_created::date = CURRENT_DATE ORDER BY date_created DESC";
$stmt = pg_prepare($con, "prescription_query", $sql);
$result = pg_execute($con, "prescription_query", array($username));


// Flag to check if diagnosis and prescription have been displayed
$diagnosisDisplayed = false;
$prescriptionDisplayed = false;
?>





                        <!-- Header with Doctor and Hospital Information -->
                        <div class="row mb-4">
                            <!-- Doctor Info -->
                            <div class="col-6">
                                <p><strong>Doctor Name:</strong> <?php echo htmlspecialchars($name); ?></p>
                                <p><strong>Doctor License ID:</strong> </p>
                            </div>

                            <div class="row">
                            <!-- Logo in center -->
                            <div class="col-6 d-flex justify-content-center">
                                <img src="../doctor2/Images/image.png" alt="Hospital Logo" style="max-height: 50px;">
                            </div>

                            <!-- Hospital Info and Logo Text on the left -->
                            <div class="col-6 text-left">
                                <p><strong style="color: #0056b3;">HOSPITAL NG NASUGBU</strong></p>
                                <p>P. RIÑOZA STREET BARANGAY 1, Nasugbu, Philippines</p>
                            </div>
                        </div>

                        </div>

                        <!-- Prescription Title -->
                        <div class="mb-4">
                            <h2 class="text-center">
                                <hr style="border: 2px solid black; width: 100%;">
                            </h2>
                        </div>

                        <div class="doctor-info text-right mb-4">
                                    <p><strong>Date:</strong> <?php echo $todayDate; ?></p>
                                </div>

                                <div class="mb-4">
                                    <p class="text-left"><strong>PID: </strong><?php echo $username; ?> &nbsp; &nbsp;|  &nbsp;  &nbsp;  <?php echo htmlspecialchars($patient['age']); ?> &nbsp;&nbsp; |  &nbsp;  &nbsp;  <?php echo htmlspecialchars($patient['sex']); ?>  &nbsp;  &nbsp; | &nbsp;&nbsp;  <strong>Mob. No: </strong> <?php echo htmlspecialchars($patient['contactnum']); ?></p>
                                    <strong>P_Name: </strong> <?php echo htmlspecialchars($patient['name']); ?></p>
                                    <div class="mb-4">
                            <h2 class="text-center">
                                <hr style="border: 1px solid black; width: 100%;">
                            </h2>

                            <br>
                        </div>
                        <style>
                            table {
                                width: 100%;
                                text-align: center; /* Centers the text within all cells */
                                border-collapse: collapse; /* Optional: for cleaner table border */
                            }
                            th, td {
                                text-align: center; /* Centers text horizontally */
                                vertical-align: middle; /* Centers content vertically */
                                padding: 8px; /* Optional: adds padding for better readability */
                            }
                        </style>

                        <!-- Health Information Table -->
                        <div class="mb-4">
                            <?php if ($vitalsData): ?>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Weight</th>
                                            <th>Height</th>
                                            <th>Blood Pressure</th>
                                            <th>Heart Rate</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo htmlspecialchars($vitalsData['weight']) . ' kg'; ?></td>
                                            <td><?php echo htmlspecialchars($vitalsData['height']) . ' cm'; ?></td>
                                            <td><?php echo htmlspecialchars($vitalsData['bloodpressure']); ?></td>
                                            <td><?php echo htmlspecialchars($vitalsData['heartrate']); ?></td>
                                        </tr>
                                    </tbody>
                        

                                </table>
                            <?php else: ?>
                                <p>No health information available.</p>
                            <?php endif; ?>
                        </div><br>

                        <div class="mb-4">
                            <h2 class="text-center">
                                <hr style="border: 1px solid black; width: 100%;">
                            </h2>
                            <br><br>

                            <?php
                                echo "<table border='1' style='width:100%;'>";
                                echo "<tr>";
                                echo "<td><strong>Chief Complaint:</strong></td>";
                                echo "<td>" . $symptoms . "</td>";
                                echo "</tr>";
                                echo "</table>";
                                ?>          


                          

                         



                        <br><br><br>

                        <!-- Prescription History -->
                        <div>
                        <div class="mb-4">
    <h4 class="text-center mb-4">Prescription List</h4>
    <?php if (pg_num_rows($result) > 0): ?>
        <table class="table table-striped table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Diagnosis</th>
                    <th>Medicine</th>
                    <th>Prescription Details</th>
                    <th>First Take</th>
                    <th>Second Take</th>
                    <th>Third Take</th>
                    <th>Fourth Take</th>
                    <th>Fifth Take</th>
                    <th>Date Created</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($prescription = pg_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($prescription['diagnosis']); ?></td>
                        <td><?php echo htmlspecialchars($prescription['prescription']); ?></td>
                        <td>
                            <?php
                                // Fetching prescription details
                                $frequency = htmlspecialchars($prescription['frequency']);
                                $dosage = htmlspecialchars($prescription['dosage']);
                                $duration = htmlspecialchars($prescription['duration']);

                                // Calculating the duration end date based on the current date and duration (in days)
                                $startDate = new DateTime(); // Today's date
                                $endDate = clone $startDate; // Clone to modify for end date
                                $endDate->modify("+{$duration} days"); // Corrected: no extra "days"

                                // Format the output for frequency, dosage, and duration with newlines
                                $frequencyLabel = "{$frequency} times a day<br>";
                                $dosageLabel = "{$dosage}<br>";
                                $durationLabel = " until {$endDate->format('m/d/y')}<br>";

                                // Echo the formatted output
                                echo "{$frequencyLabel} {$dosageLabel} {$durationLabel}";
                            ?>
                        </td>
                        <td>
                            <?php 
                                echo is_null($prescription['first_take']) ? 'N/A' : (new DateTime($prescription['first_take']))->format('h:i a');
                            ?>
                        </td>
                        <td>
                            <?php 
                                echo is_null($prescription['second_take']) ? 'N/A' : (new DateTime($prescription['second_take']))->format('h:i a');
                            ?>
                        </td>
                        <td>
                            <?php 
                                echo is_null($prescription['third_take']) ? 'N/A' : (new DateTime($prescription['third_take']))->format('h:i a');
                            ?>
                        </td>
                        <td>
                            <?php 
                                echo is_null($prescription['fourth_take']) ? 'N/A' : (new DateTime($prescription['fourth_take']))->format('h:i a');
                            ?>
                        </td>
                        <td>
                            <?php 
                                echo is_null($prescription['fifth_take']) ? 'N/A' : (new DateTime($prescription['fifth_take']))->format('h:i a');
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($prescription['date_created']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center text-muted">No prescription history available.</p>
    <?php endif; ?>
</div>




                        </div>

                        </div>

                        <div class="mb-4">
                            <h2 class="text-center">
                                <hr style="border: 1px solid black; width: 100%;">
                            </h2>

                            <br><br>
                        <?php
                        // Remove 'Treatment:' from the beginning of the predicted treatment text
                        $treatment = str_replace('Treatment:', '', $prediction['predicted_treatment']);

                        // Split the treatment string by commas and trim any extra spaces
                        $treatmentArray = array_map('trim', explode(',', $treatment));

                        // Join the array elements with newline characters for plain text output
                        $treatmentFormatted = implode("\n * ", $treatmentArray);

                        // Output the treatment with safe HTML encoding, wrapped in a <pre> tag for formatting
                        echo '<p><strong>Treatment:</strong></p>';
                        echo '<pre>' . '&nbsp' . '*' . '&nbsp' . htmlspecialchars($treatmentFormatted) .'</pre>';
                        ?> <br> <br>


                        <script>
                        // Function to print the prescription
                        function printPrescription() {
                        var printContent = document.querySelector('.printtable').innerHTML;
                        var originalContent = document.body.innerHTML;
                        document.body.innerHTML = printContent; // Replace body content with the prescription table
                        window.print(); // Trigger the print dialog
                        document.body.innerHTML = originalContent; // Restore original content after printing
                        }
                        </script>

                        <style>
                            /* Page-specific styling for printing */
                        @media print {
                        body {
                            margin: 0;
                            padding: 0;
                            width: 100%;
                            height: auto; /* Ensure dynamic height */
                        }
                        .printtable {
                            width: 100%;
                            max-width: 100%;
                            margin: 0;
                            padding: 10px;
                        }
                        .text-right {
                            text-align: right !important;
                        }
                        .btn {
                            display: none; /* Hide buttons during printing */
                        }
                        h2, h4 {
                            text-align: center;
                        }
                        /* Prevent page breaks within elements */
                        .printtable, h2, h4 {
                            page-break-inside: avoid;
                        }
                        }

                        </style>




                        <!-- Add Bootstrap JS for modal functionality (if not included already) -->
                        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

                        <?php
                        } else {
                            echo "<div class='container mt-5'><p class='text-danger text-center'>Patient not found.</p></div>";
                        }
                        } else {
                            echo "<div class='container mt-5'><p class='text-warning text-center'>No patient selected.</p></div>";
                        }

                      
                        ?>









 <!-- for displaying patient data  -->
   

    <!-- jQuery -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
