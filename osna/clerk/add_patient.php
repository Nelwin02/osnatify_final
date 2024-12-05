<?php
session_start(); // Start session at the beginning to avoid any issues with headers

include '../db.php'; // Database connection file

// Check if clerk is logged in by verifying the session variable
if (!isset($_SESSION['clerk_username'])) { // Changed to clerk_username
    header("Location: /osna/doctor2/login.php");
    exit();
}

// Retrieve the clerk's username from session
$clerk_username = $_SESSION['clerk_username']; // Updated session variable

// Fetch clerk information using prepared statements
$query = "SELECT clerk_name, clerk_image FROM clerk_log WHERE username = $1"; // Using clerk_username in the query
$stmt = pg_prepare($con, "fetch_clerk_info", $query);
$result = pg_execute($con, "fetch_clerk_info", array($clerk_username));

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

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/osna/clerk/phpmailer/src/Exception.php';
require '/osna/clerk/phpmailer/src/PHPMailer.php';
require '/osna/clerk/phpmailer/src/SMTP.php';

$usernameNumber = rand(0, 999);
$passwordNumber = rand(0, 999);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['step1'])) {
        // Format the numbers as '00 001'
        $_SESSION['username'] = sprintf('%02d %03d', floor($usernameNumber / 100), $usernameNumber % 100);
        $_SESSION['password'] = sprintf('%02d %03d', floor($passwordNumber / 100), $passwordNumber % 100);

        // Check if email is set and assign to session, else set it to null
        $_SESSION['email'] = !empty($_POST['email']) ? $_POST['email'] : 'optional@gmail.com';

        $_SESSION['step'] = 2;
    } elseif (isset($_POST['step2'])) {
        $_SESSION['name'] = $_POST['name'];
        $_SESSION['guardian'] = $_POST['guardian'];
        $_SESSION['address'] = $_POST['address'];
        $_SESSION['contactnum'] = $_POST['contactnum'];
        $_SESSION['age'] = $_POST['age'];
        $_SESSION['sex'] = $_POST['sex'];
        $_SESSION['civil_status'] = $_POST['civil_status'];
        $_SESSION['dob'] = $_POST['dob'];
        $_SESSION['step'] = 3;
    } elseif (isset($_POST['submit'])) { 
        // Database connection details
        $host = 'dpg-ct2lk83qf0us739u2uvg-a.oregon-postgres.render.com';
        $port = '5432';  // Default PostgreSQL port
        $dbname = 'opdmsis';
        $user = 'opdmsis_user';
        $password = '3sc6VNaexgXhje2UgoQ4fnvPf8x1KDGG';
        
        // Create connection string
        $conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";

        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
        $email = $_SESSION['email'];
        $name = $_SESSION['name'];
        $guardian = $_SESSION['guardian'];
        $address = $_SESSION['address'];
        $contactnum = $_SESSION['contactnum'];
        $age = $_SESSION['age'];
        $sex = $_SESSION['sex'];
        $civil_status = $_SESSION['civil_status'];
        $dob = $_SESSION['dob'];

        // Check if the username already exists
        $stmt = pg_prepare($con, "check_username", "SELECT username FROM patient_info WHERE username = $1");
        $result = pg_execute($con, "check_username", array($username));

        if (pg_num_rows($result) > 0) {
            // Username already exists
            echo "<script>alert('Username already exists.');</script>";
        } else {
            // Insert new record
            $sql = "INSERT INTO patient_info (username, password, email, name, guardian, address, contactnum, age, sex, civil_status, dob) 
                    VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11)";
            
            $result = pg_prepare($con, "insert_patient", $sql);
            $result = pg_execute($con, "insert_patient", array(
                $username, $password, $email, $name, $guardian, $address, 
                $contactnum, $age, $sex, $civil_status, $dob
            ));

            if ($result) {
                // Set session variable to indicate success
                $_SESSION['registration_success'] = true;

                // Send email
                if ($email) {
                    $mail = new PHPMailer(true);
                    try {
                        // Server settings
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com'; // Your SMTP server
                        $mail->SMTPAuth = true;
                        $mail->Username = 'osnanotify@gmail.com'; // Your SMTP username
                        $mail->Password = 'eynrorlknfmjcktr'; // Your SMTP password (use environment variable in production)
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
                        $mail->Port = 587; // TCP port to connect to
                
                        // Recipients
                        $mail->setFrom('osnanotify@gmail.com', 'Ospital Ng Nasugbu');
                        $mail->addAddress($email); // Add recipient only if email is provided
                
                        // Content
                        $mail->isHTML(true);
                        $mail->Subject = 'Your Account Information';
                
                        $mail->Body = "
                        <html>
                        <head>
                            <style>
                                body {
                                    font-family: Arial, sans-serif;
                                    line-height: 1.6;
                                    background-color: #f4f4f4;
                                    margin: 0;
                                    padding: 0;
                                }
                                .container {
                                    max-width: 600px;
                                    margin: 20px auto;
                                    padding: 20px;
                                    border: 1px solid #ccc;
                                    border-radius: 5px;
                                    background-color: #ffffff;
                                }
                                h2 {
                                    color: #333;
                                }
                                p {
                                    margin: 10px 0;
                                }
                                .view-more {
                                    margin-top: 10px;
                                    text-align: right;
                                }
                                .view-more a {
                                    color: #007bff;
                                    text-decoration: none;
                                    font-weight: bold;
                                }
                                .view-more a:hover {
                                    text-decoration: underline;
                                }
                            </style>
                        </head>
                        <body>
                            <div class='container'>
                                <h2>Hello $name,</h2>
                                <p>Your account has been successfully created.</p>
                                <p><strong>Username:</strong> $username</p>
                                <p><strong>Password:</strong> $password</p>
                                <div class='view-more'>
                                    <p>View all records:</p>
                                    <a href=''>Download app here!</a>
                                </div>
                            </div>
                        </body>
                        </html>
                        ";
                
                        // Send the email
                        $mail->send();
                    } catch (Exception $e) {
                        echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
                    }
                }
                
            }
        }

        pg_free_result($stmt);
        pg_close($con);
    }
} else {
    $_SESSION['step'] = 1;
}
?>
<!DOCTYPE html>
<html lang="en">
    
<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:20 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Add Patient</title>
		
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

   
<!-- Check for success session variable and trigger modal -->
<script>
$(document).ready(function() {
    <?php if (isset($_SESSION['registration_success'])): ?>
        $('#successModal').modal('show');
        <?php unset($_SESSION['registration_success']); // Unset it after showing ?>
    <?php endif; ?>
});
</script>


</div>
</body>
</html>







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
								<h3 class="page-title">Welcome, <?php echo $name; ?></h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="clerk_dash.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Adding New Patient</li>
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
                    <div class="container">
    <div class="steps">
        <div class="step <?php if ($_SESSION['step'] == 1) echo 'active'; ?>">
            <span class="number">1</span>
            <span class="check-icon">&#10004;</span>
        </div>---------
        <div class="step <?php if ($_SESSION['step'] == 2) echo 'active'; ?>">
            <span class="number">2</span>
            <span class="check-icon">&#10004;</span>
        </div>---------
        <div class="step <?php if ($_SESSION['step'] == 3) echo 'active'; ?>">
            <span class="number">3</span>
            <span class="check-icon">&#10004;</span>
        </div>
       
    </div>

    <?php if ($_SESSION['step'] == 1): ?>
       
        <form action="" method="post" id="step1-form">
          
        <div class="form-group row">
        <label for="email">Email &nbsp; &nbsp;</label>
        <input type="email" class="form-control form-control-small" id="email" name="email" placeholder="Optional">
</div>

<div style="display: flex; justify-content: flex-end;">
    <button type="submit" name="step1" class="btn btn-primary" onclick="completeStep(1)">Next</button>
</div>

        </form>
        <div class="note mt-3 text-center">
                        <p><strong style="color: red; font-weight: bold;">Note: </strong>Please enter the patient's email if available.</p>
                    </div>
    <?php elseif ($_SESSION['step'] == 2): ?>
        <h2 style="text-align: center; font-weight: bold;">Patient Personal Information</h2><br><br>
        <form action="" method="post" id="step2-form">
            <div class="form-group row">
            <div class="form-group col-md-3">
                <label for="name">Name: LN | FN | MN</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="ex. Delacruz Juan Lee" required>
            </div>
            <div class="form-group col-md-3">
                <label for="guardian">Guardian: LN | FN | MN</label>
                <input type="text" class="form-control" id="guardian" name="guardian" placeholder="ex. Delacruz Juan Lee" required>
            </div>
            <div class="form-group col-md-3">
    <label for="address">Full Address (Barangay):</label>
    <input type="text" class="form-control" id="address" name="address" placeholder="Barangay" onkeyup="searchAddress()" required>
    <div id="addressSuggestions" class="suggestions-box"></div>
</div>

<script>
// List of Barangays in Nasugbu, Batangas
const barangays = [
    'Aga, Nasugbu, Batangas',
    'Balaytigui, Nasugbu, Batangas',
    'Banilad, Nasugbu, Batangas',
    'Barangay 1, Nasugbu, Batangas',
    'Barangay 10, Nasugbu, Batangas',
    'Barangay 11, Nasugbu, Batangas',
    'Barangay 12, Nasugbu, Batangas',
    'Barangay 2, Nasugbu, Batangas',
    'Barangay 3, Nasugbu, Batangas',
    'Barangay 4, Nasugbu, Batangas',
    'Barangay 5, Nasugbu, Batangas',
    'Barangay 6, Nasugbu, Batangas',
    'Barangay 7, Nasugbu, Batangas',
    'Barangay 8, Nasugbu, Batangas',
    'Barangay 9, Nasugbu, Batangas',
    'Bilaran, Nasugbu, Batangas',
    'Bucana, Nasugbu, Batangas',
    'Bulihan, Nasugbu, Batangas',
    'Bunducan, Nasugbu, Batangas',
    'Butucan, Nasugbu, Batangas',
    'Calayo, Nasugbu, Batangas',
    'Catandaan, Nasugbu, Batangas',
    'Cogunan, Nasugbu, Batangas',
    'Dayap, Nasugbu, Batangas',
    'Kaylaway, Nasugbu, Batangas',
    'Kayrilaw, Nasugbu, Batangas',
    'Latag, Nasugbu, Batangas',
    'Looc, Nasugbu, Batangas',
    'Lumbangan, Nasugbu, Batangas',
    'Malapad na Bato, Nasugbu, Batangas',
    'Mataas na Pulo, Nasugbu, Batangas',
    'Maugat, Nasugbu, Batangas',
    'Munting Indan, Nasugbu, Batangas',
    'Natipuan, Nasugbu, Batangas',
    'Pantalan, Nasugbu, Batangas',
    'Papaya, Nasugbu, Batangas',
    'Putat, Nasugbu, Batangas',
    'Reparo, Nasugbu, Batangas',
    'Talangan, Nasugbu, Batangas',
    'Tumalim, Nasugbu, Batangas',
    'Utod, Nasugbu, Batangas',
    'Wawa, Nasugbu, Batangas'
];

// Function to search and display Barangay suggestions
function searchAddress() {
    const input = document.getElementById("address").value;
    const suggestionsBox = document.getElementById("addressSuggestions");
    suggestionsBox.innerHTML = ''; // Clear previous suggestions

    if (input.length > 0) {
        const filteredBarangays = barangays.filter(barangay => 
            barangay.toLowerCase().includes(input.toLowerCase())
        );

        // Create suggestions list
        filteredBarangays.forEach(barangay => {
            const suggestion = document.createElement("div");
            suggestion.classList.add("suggestion-item");
            suggestion.textContent = barangay;
            suggestion.onclick = function() {
                document.getElementById("address").value = barangay; // Set selected Barangay in the input
                suggestionsBox.innerHTML = ''; // Clear suggestions after selection
            };
            suggestionsBox.appendChild(suggestion);
        });
    }
}

// Optional: Styling for suggestions (add this to your CSS file)
const style = document.createElement('style');
style.innerHTML = `
    .suggestions-box {
        border: 1px solid #ddd;
        max-height: 150px;
        overflow-y: auto;
        position: absolute;
        z-index: 1000;
        background: #fff;
    }
    .suggestion-item {
        padding: 8px;
        cursor: pointer;
    }
    .suggestion-item:hover {
        background-color: #f0f0f0;
    }
`;
document.head.appendChild(style);
</script>

            <div class="form-group col-md-3">
                <label for="contactnum">Contact Number:</label>
                <input type="text" class="form-control" id="contactnum" name="contactnum" required>
            </div>
        </div>
        <div class="form-row">
        <div class="form-group col-md-3">
                <label for="dob">Date of Birth:</label>
                <input type="date" class="form-control" id="dob" name="dob" required>
            </div>
            <div class="form-group col-md-3">
                <label for="age">Age:</label>
                <input style="text-align: center;" type="number" class="form-control" id="age" name="age" required>
            </div>
            <div class="form-group col-md-3">
                <label for="sex">Sex:</label>
                <select class="form-control" id="sex" name="sex" required>
                    <option value="">Select Sex</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="civil_status">Civil Status</label>
                <select class="form-control" id="sex" name="civil_status" required>
                    <option value="">Select Status</option>
                    <option value="single">Single</option>
                    <option value="married">Married</option>
                    <option value="divorced">Divorced</option>
                    <option value="widowed">Widowed</option>

                </select>
                <br> <br>

                <div style="display: flex; justify-content: flex-end; gap: 10px;">
    <a href="?step=1" class="btn btn-secondary"><i class="fa fa-arrow-left"></i></a>
    <button type="submit" name="step2" class="btn btn-primary" onclick="completeStep(2)">Next</button>
            </div>

           
            <script>
                //compute the age base on birthdate
                document.getElementById('dob').addEventListener('change', function() {
                        const dob = new Date(this.value);
                        const today = new Date();
                        let age = today.getFullYear() - dob.getFullYear();
                        const monthDifference = today.getMonth() - dob.getMonth();

                        
                        if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < dob.getDate())) {
                            age--;
                        }

                        
                        document.getElementById('age').value = age;
                    });

            </script>
            
           
</div>


            
        </form>
  

        <?php elseif ($_SESSION['step'] == 3): ?>
    <h2 style="text-align: center; font-weight: bold;">Review Patient Data</h2><br><br>
    <form action="" method="post" id="step4-form">
       
    <div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm" style="border: none;">
            <div class="card-header bg-primary text-white">
                <h4>Patient Information</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Username:</strong> ***</p>
                        <p><strong>Password:</strong> ***</p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
                        <p><strong>Name:</strong> <?php echo $_SESSION['name']; ?></p>
                        <p><strong>Guardian:</strong> <?php echo $_SESSION['guardian']; ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Address:</strong> <?php echo $_SESSION['address']; ?></p>
                        <p><strong>Contact Number:</strong> <?php echo $_SESSION['contactnum']; ?></p>
                        <p><strong>Date of Birth:</strong> <?php echo $_SESSION['dob']; ?></p>
                        <p><strong>Age:</strong> <?php echo $_SESSION['age']; ?></p>
                        <p><strong>Sex:</strong> <?php echo $_SESSION['sex']; ?></p>
                        <p><strong>Civil Status:</strong> <?php echo $_SESSION['civil_status']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal structure -->
<div id="successModal" class="modal" style="display: none;">
    <div class="modal-content">
        <p>New patient added. Ready for consultation!</p>
        <button id="okButton" style="background-color: green; color: white; padding: 10px 20px; border: none; cursor: pointer;">OK</button>
    </div>
</div>
<style>
        .modal {
    display: none;
    position: fixed;
    z-index: 1000; /* Higher z-index for modal */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8); /* Darker modal background */
}

.modal-content {
    background-color: #ffffff;
    margin: 15% auto;
    padding: 30px; /* Increased padding for more space */
    border: 1px solid #888;
    border-radius: 10px; /* Rounded corners */
    width: 80%;
    max-width: 400px; /* Slightly wider modal */
    text-align: center;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3); /* Shadow for depth */
}

.modal-content button {
    padding: 10px 20px;
    background-color: #28a745; /* Bootstrap success color */
    color: white;
    border: none;
    border-radius: 5px; /* Rounded button */
    cursor: pointer;
    font-weight: bold;
}

.modal-content button:hover {
    background-color: #218838; /* Darker green on hover */
}

</style>


<!-- Your Submit Button -->
<div class="text-center mt-4" style="display: flex; justify-content: flex-end; gap: 10px;">
    <a href="?step=3" class="btn btn-outline-secondary"><i class="fa fa-arrow-left"></i> Back</a>
    <button type="submit" name="submit" class="btn btn-success" onclick="openModal()">Submit</button>
</div>

<script>
    // Function to show the modal
    function openModal() {
        var modal = document.getElementById("successModal");
        modal.style.display = "block";
    }

    // Button click to close modal and redirect
    document.getElementById("okButton").onclick = function() {
        var modal = document.getElementById("successModal");
        modal.style.display = "none";
        
        // Redirect back to add_patient.php step 1
        window.location.href = "add_patient.php?step=1";
    };
</script>

<style>
    /* Simple modal styling */
    .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .modal-content {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
    }
</style>


</div>

        </div>
    </form>
<?php endif; ?>

<style>
    .card {
        margin-top: 5px;
        border-radius: 10px;
    }
    .card-header {
        border-top-left-radius: 5px;
        border-top-right-radius: 10px;
    }
    p {
        margin: 0;
        padding: 10px 0;
        font-size: 16px;
        color: #333;
    }
    .btn {
        margin: 5px;
    }
</style>

					
					
		
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
		<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to mark the step as complete and display the check icon
    function completeStep(step) {
        const stepElement = document.querySelector(`.step:nth-child(${step})`);
        stepElement.classList.add('completed');
        stepElement.querySelector('.check-icon').style.display = 'inline';

        if (step === 3) {
            stepElement.querySelector('.step-text').textContent = 'Step 4 Complete';
        }
    }

    // Check which step is active and mark the previous steps as complete
    const steps = document.querySelectorAll('.step');
    steps.forEach((stepElement, index) => {
        if (stepElement.classList.contains('active')) {
            for (let i = 0; i < index; i++) {
                completeStep(i + 1);
            }
        }
    });

    // Event listeners for form submissions
    document.querySelector('#step1-form').addEventListener('submit', function(event) {
        completeStep(1);
    });

    document.querySelector('#step2-form').addEventListener('submit', function(event) {
        completeStep(2);
    });

    document.querySelector('#step3-form').addEventListener('submit', function(event) {
        completeStep(3);
    });

  
});





        </script>
    </body>

<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:34 GMT -->
</html>
