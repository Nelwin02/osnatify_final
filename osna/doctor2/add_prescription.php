<!DOCTYPE html>
<html lang="en">
    
<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:20 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Add Prescription</title>
		
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


$sql = "SELECT doctor_name, doctor_image FROM doctor_log WHERE username = $1";
$result = pg_query_params($con, $sql, array($username));

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
include 'db.php';
// Fetch current status from the database
$status_query = "SELECT status FROM patient_info WHERE username = $1";
$status_result = pg_query_params($con, $status_query, array($username));
if ($status_result) {
    $status_row = pg_fetch_assoc($status_result);
    $status = $status_row['status'];
} else {
    $status = null;  // If status fetch fails, set $status to null
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
                    <div class="page-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="page-title">Prescription</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="clerk_dash.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Add Prescription</li>
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
include('db.php'); // Contains the database connection logic
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require './phpmailer/src/Exception.php';
require './phpmailer/src/PHPMailer.php';
require './phpmailer/src/SMTP.php';

// Retrieve username from URL
$username = isset($_GET['username']) ? $_GET['username'] : null;

if ($username) {
    // Fetch the patient's name and email from the patient_info table
    $query = "SELECT name, email FROM patient_info WHERE username = $1";
    $result = pg_query_params($con, $query, [$username]);

    if ($row = pg_fetch_assoc($result)) {
        $name = $row['name'];
        $email = $row['email'];
    } else {
        $name = 'Patient Not Found';
        $email = ''; // No email found
    }

    // Fetch prediction data (symptoms, predicted_disease, predicted_prescription)
    $query = "SELECT symptoms, predicted_disease, predicted_prescription FROM prediction WHERE username = $1";
    $result = pg_query_params($con, $query, [$username]);

    if ($row = pg_fetch_assoc($result)) {
        $symptoms = $row['symptoms'];
        $predicted_disease = $row['predicted_disease'];
        $predicted_prescription = $row['predicted_prescription'];
    } else {
        $symptoms = $predicted_disease = $predicted_prescription = '';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $username) {
    // Get form data for prescription
    $diagnosis = $_POST['diagnosis'];
    $prescription = $_POST['prescription'];
    $frequency = $_POST['frequency'];
    $dosage = $_POST['dosage'];
    $duration = $_POST['duration'];
    $first_take = !empty($_POST['first_take']) ? $_POST['first_take'] : null;
    $second_take = !empty($_POST['second_take']) ? $_POST['second_take'] : null;
    $third_take = !empty($_POST['third_take']) ? $_POST['third_take'] : null;
    $fourth_take = !empty($_POST['fourth_take']) ? $_POST['fourth_take'] : null;
    $fifth_take = !empty($_POST['fifth_take']) ? $_POST['fifth_take'] : null;

    // Insert prescription data into the doctor_confirm table
    $query = "INSERT INTO doctor_confirm 
              (username, diagnosis, prescription, frequency, dosage, duration, first_take, second_take, third_take, fourth_take, fifth_take) 
              VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11)";
    $params = [$username, $diagnosis, $prescription, $frequency, $dosage, $duration, $first_take, $second_take, $third_take, $fourth_take, $fifth_take];

    $result = pg_query_params($con, $query, $params);

    if ($result) {
        // Update the status to 'approve' where the status is 'pending'
        $update_query = "UPDATE patient_info SET status = 'approve' WHERE status = 'pending' AND username = $1";
        pg_query_params($con, $update_query, [$username]);

        // Send Email to the Patient
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'osnanotify@gmail.com'; // Your email address
            $mail->Password = 'eynrorlknfmjcktr'; // Your email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Set From and To email addresses
            $mail->setFrom('osnanotify@gmail.com', 'Ospital Ng Nasugbu');
            $mail->addAddress($email, $name);

            // Subject and body of the email
            $mail->Subject = 'Your Prescription from Ospital Ng Nasugbu';
            $mail->Body = "
                Dear $name,<br><br>
                We would like to inform you about your recent consultation and prescribed medication.<br><br>
                <strong>Diagnosis:</strong> $diagnosis<br>
                <strong>Prescribed Medicine:</strong> $prescription<br>
                <strong>Frequency:</strong> $frequency<br>
                <strong>Dosage:</strong> $dosage<br>
                <strong>Duration:</strong> $duration<br><br>
                <strong>Instructions:</strong><br>
                1. First Take: $first_take<br>
                2. Second Take: $second_take<br>
                3. Third Take: $third_take<br>
                4. Fourth Take: $fourth_take<br>
                5. Fifth Take: $fifth_take<br><br>
                Please follow the instructions carefully. If you have any questions, feel free to contact us.<br><br>
                Best regards,<br>
                Ospital Ng Nasugbu
            ";
            $mail->isHTML(true);

            if (!$mail->send()) {
                throw new Exception("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
            }
        } catch (Exception $e) {
            echo "Email could not be sent. Error: " . $e->getMessage();
        }

        echo '<div id="successModal" class="modal">
                <div class="modal-content">
                    <h4>Success!</h4>
                    <p>The prescription has been added successfully.</p>
                    <button onclick="window.location.href=\'view_prediction.php?username=' . urlencode($username) . '\'">OK</button>
                </div>
              </div>';
    } else {
        echo "<p>Error adding prescription: " . pg_last_error($con) . "</p>";
    }
}

if ($username) {
?>
<h5 style="text-align: left;"><?php echo htmlspecialchars($name); ?></h5>
<h5 style="text-align: left;"><?php echo htmlspecialchars($username); ?></h5>

<div class="row">
    
    <!-- Prescription Form Column -->
    <div class="col-md-8">
        <div class="card mt-5 shadow-lg rounded">
            <div class="card-header bg-primary text-black text-center">
            <h5 style="text-align: center;">Add Prescription</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <!-- Table layout for Symptoms, Diagnosis, and Prescription -->
                    <table class="table">
                        <tr>
                            <td><strong>Symptoms</strong></td>
                            <td><textarea class="form-control" name="symptoms" required><?php echo htmlspecialchars($symptoms); ?></textarea></td>
                        </tr>
                        <tr>
    <td><strong>Diagnosis</strong></td>
    <td>
        <textarea 
            class="form-control" 
            type="text" 
            name="diagnosis" 
            id="diagnosis" 
            required 
            oninput="validateDiagnosis()"><?php echo htmlspecialchars(str_replace('Diagnosis: ', '', $predicted_disease)); ?></textarea>
        <small id="diagnosisError" style="color: red; display: none;"></small>
    </td>
</tr>
<tr>
    <td><strong>Medicine</strong></td>
    <td>
        <textarea 
            class="form-control" 
            type="text" 
            name="prescription" 
            id="prescription" 
            required 
            oninput="validatePrescription()"><?php echo htmlspecialchars(str_replace('Prescription: ', '', $predicted_prescription)); ?></textarea>
        <small id="prescriptionError" style="color: red; display: none;"></small>
    </td>
</tr>
<script>
    const initialDiagnosis = "<?php echo htmlspecialchars(str_replace('Diagnosis: ', '', $predicted_disease)); ?>";
    const initialPrescription = "<?php echo htmlspecialchars(str_replace('Prescription: ', '', $predicted_prescription)); ?>";

    function validateDiagnosis() {
        const diagnosisField = document.getElementById('diagnosis');
        const diagnosisError = document.getElementById('diagnosisError');
        if (diagnosisField.value.trim() === initialDiagnosis.trim()) {
            diagnosisError.style.display = 'block';
            diagnosisField.setCustomValidity('Please edit the diagnosis. check the guide!');
        } else {
            diagnosisError.style.display = 'none';
            diagnosisField.setCustomValidity('');
        }
    }

    function validatePrescription() {
        const prescriptionField = document.getElementById('prescription');
        const prescriptionError = document.getElementById('prescriptionError');
        if (prescriptionField.value.trim() === initialPrescription.trim()) {
            prescriptionError.style.display = 'block';
            prescriptionField.setCustomValidity('Please edit the prescription. check the guide!');
        } else {
            prescriptionError.style.display = 'none';
            prescriptionField.setCustomValidity('');
        }
    }

    // Initial validation for onload (optional, if the form is pre-filled)
    document.addEventListener('DOMContentLoaded', () => {
        validateDiagnosis();
        validatePrescription();
    });
</script>

                    </table>

                    <!-- Frequency Handling -->
                    <div class="form-group mb-4">
                        <label for="frequency" class="font-weight-bold">Frequency:</label>
                        <select class="form-control" id="frequency" name="frequency" required onchange="showTimes()">
                            <option value="1">1 time a day</option>
                            <option value="2">2 times a day</option>
                            <option value="3">3 times a day</option>
                            <option value="4">4 times a day</option>
                            <option value="5">5 times a day</option>
                        </select>
                    </div>

                    <!-- Dynamic Time Inputs -->
                    <div class="form-group mb-4" id="timeFields">
                        <div class="time-field" id="first_time" style="display:block;">
                            <label for="first_take" class="font-weight-bold">Time of Dosage (1st to take)</label>
                            <input class="form-control" type="time" name="first_take">
                        </div>
                        <div class="time-field" id="second_time" style="display:none;">
                            <label for="second_take" class="font-weight-bold">Time of Dosage (2nd to take)</label>
                            <input class="form-control" type="time" name="second_take">
                        </div>
                        <div class="time-field" id="third_time" style="display:none;">
                            <label for="third_take" class="font-weight-bold">Time of Dosage (3rd to take)</label>
                            <input class="form-control" type="time" name="third_take">
                        </div>
                        <div class="time-field" id="fourth_time" style="display:none;">
                            <label for="fourth_take" class="font-weight-bold">Time of Dosage (4th to take)</label>
                            <input class="form-control" type="time" name="fourth_take">
                        </div>
                        <div class="time-field" id="fifth_time" style="display:none;">
                            <label for="fifth_take" class="font-weight-bold">Time of Dosage (5th to take)</label>
                            <input class="form-control" type="time" name="fifth_take">
                        </div>
                    </div>

                    <div class="form-group mb-4">
                    <label for="dosage" class="font-weight-bold">Dosage (including quantity):</label>
                    <input class="form-control" type="text" id="dosage" name="dosage" placeholder="e.g. 500 mg | Quantity" required>
                </div>

                <div class="form-group mb-4">
                <label for="duration" class="font-weight-bold">Duration:</label>
                <input class="form-control" type="number" id="duration" name="duration" required>
            </div>


                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success btn-lg">Save Prescription</button>
                        <a href="view_prediction.php?username=<?php echo urlencode($username); ?>" class="btn btn-outline-secondary btn-lg">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Guide Column -->
    <div class="col-md-4">
        <div class="card mt-5 shadow-lg rounded">
            <div class="card-header bg-info text-white text-center">
                <h5>Prescription Guide</h5>
            </div>
            <div class="card-body">
                <ul>
                    <li><strong>Symptoms:</strong> Describe the symptoms observed in the patient.</li>
                    <li><strong>Diagnosis:</strong> Enter the medical diagnosis for the patient.</li>
                    <li><strong>Medicine:</strong> Provide the medication prescribed to the patient.</li>
                    <li><strong>Frequency:</strong> Select how many times a day the medication should be taken.</li>
                    <li><strong>Time of Dosage:</strong> Adjust the times when the medication should be taken.</li>
                    <li><strong>Dosage:</strong> Enter the dosage amount for the patient.</li>
                    <li><strong>Duration:</strong> Specify the duration for which the medication should be taken.</li>
                </ul>
                <p>Ensure all fields are filled out correctly before submitting the prescription.</p>
            </div>
        </div>
    </div>
</div>


<script>
function showTimes() {
    var frequency = document.getElementById('frequency').value;
    var times = ['first_time', 'second_time', 'third_time', 'fourth_time', 'fifth_time'];
    
    // Hide all time fields
    for (var i = 0; i < times.length; i++) {
        document.getElementById(times[i]).style.display = 'none';
    }
    
    // Show required time fields based on frequency
    for (var i = 0; i < frequency; i++) {
        document.getElementById(times[i]).style.display = 'block';
    }
}
</script>

<?php
} else {
    echo "<p>No patient selected for adding prescription.</p>";
}


?>




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
