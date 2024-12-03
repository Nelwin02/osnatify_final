

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
		

		
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->

		<?php
session_start();
include 'db.php'; 
?>

<?php
// Check if clerk is logged in by verifying the session variable
if (!isset($_SESSION['clerk_username'])) { // Changed to clerk_username
    header("Location: login.php");
    exit();
}

// Retrieve the clerk's username from session
$clerk_username = $_SESSION['clerk_username']; // Updated session variable

// Fetch clerk information using PostgreSQL
$sql = "SELECT clerk_name, clerk_image FROM clerk_log WHERE username = $1"; // $1 is a placeholder for parameter binding
$result = pg_prepare($con, "get_clerk_info", $sql); // Prepare the query
$result = pg_execute($con, "get_clerk_info", array($clerk_username)); // Execute the query with the session username

if ($result) {
    $clerk = pg_fetch_assoc($result); // Fetch the row as an associative array
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
                                <li class="breadcrumb-item"><a href="clerk_dash.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Edit Patient</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="mb-4">
                            <h2 class="text-center">
                                <hr style="border: 2px solid black; width: 100%;">
                            </h2>
                        </div>

                        <br>


                        <?php
// Start output buffering at the top of the script
ob_start();

// Include your database connection
include('db.php');

if (isset($_GET['username'])) {
    $username = $_GET['username'];

    // Fetch the patient's details using prepared statements to prevent SQL injection
    $query = "SELECT * FROM patient_info WHERE username = $1 ORDER BY id DESC";
    if ($stmt = pg_prepare($con, "get_patient", $query)) {
        $result = pg_execute($con, "get_patient", array($username));

        if ($result && pg_num_rows($result) > 0) {
            $patient = pg_fetch_assoc($result);
        } else {
            echo "Patient not found.";
            exit;
        }
    }
}

// Handling the form submission (update patient info)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $name = $_POST['name'];
    $address = $_POST['address'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $contactnum = $_POST['contactnum'];
    $civil_status = $_POST['civil_status'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];

    // Validate the sex input
    if ($sex !== 'male' && $sex !== 'female') {
        echo "Invalid sex value.";
        exit;
    }

    // Update patient info
    $updateQuery = "UPDATE patient_info 
                    SET name = $1, address = $2, contactnum = $3, civil_status = $4, dob = $5, age = $6, sex = $7, email = $8 
                    WHERE username = $9";
    if ($stmt = pg_prepare($con, "update_patient", $updateQuery)) {
        $result = pg_execute($con, "update_patient", array($name, $address, $contactnum, $civil_status, $dob, $age, $sex, $email, $username));

        if ($result) {
            // Restore original date_created
            $restoreDateQuery = "UPDATE patient_info SET date_created = $1 WHERE username = $2";
            if ($restoreStmt = pg_prepare($con, "restore_date", $restoreDateQuery)) {
                pg_execute($con, "restore_date", array($patient['date_created'], $username));
            }

            // Success: Show the modal with success message
            echo "<script>
            var modal = document.createElement('div');
            var modalContent = document.createElement('div');
            var modalText = document.createElement('p');
            var okButton = document.createElement('button');

            modal.style.position = 'fixed';
            modal.style.top = '0';
            modal.style.left = '0';
            modal.style.width = '100%';
            modal.style.height = '100%';
            modal.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
            modal.style.display = 'flex';
            modal.style.alignItems = 'center';
            modal.style.justifyContent = 'center';

            modalContent.style.backgroundColor = 'white';
            modalContent.style.padding = '20px';
            modalContent.style.borderRadius = '5px';
            modalContent.style.textAlign = 'center';
            modalContent.style.width = '300px';

            modalText.textContent = 'Patient details updated successfully!';
            modalText.style.marginBottom = '20px';

            okButton.textContent = 'OK';
            okButton.style.padding = '10px 20px';
            okButton.style.backgroundColor = 'green';
            okButton.style.color = 'white';
            okButton.style.border = 'none';
            okButton.style.borderRadius = '5px';
            okButton.style.cursor = 'pointer';
            
            modalContent.appendChild(modalText);
            modalContent.appendChild(okButton);
            modal.appendChild(modalContent);
            document.body.appendChild(modal);

            okButton.onclick = function() {
                modal.style.display = 'none';
                window.location.href = 'consultation.php?username=" . urlencode($username) . "'; 
            }
            </script>";
        } else {
            echo "Error updating patient details.";
        }
    }
}

// Flush the output buffer and end the script
ob_end_flush();
?>




    

    <style>
       
       .container {
    width: 100%;
    max-width: 650px;
    margin: 50px auto;
    padding: 20px;
    background-color: #FBFBFB;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
}

.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    position: relative;
}

.form-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
}

.form-group label {
    font-weight: bold;
    margin-bottom: 5px;
   
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 10px 40px 10px 10px; /* Increase padding on the right to make space for the icon */
    border-radius: 4px;
    border: 1px solid #ddd;
    font-size: 16px;
    box-sizing: border-box;
}

.form-group i {
    position: absolute;
    top: 50%;
    right: 20px;  /* Position the icon on the right side inside the input */
    transform: translateY(-5%);  /* Center the icon vertically */
    color: #aaa;
}

button {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 10px 15px;
    font-size: 16px;
    width: 100%;
    cursor: pointer;
    border-radius: 4px;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #45a049;
}

h2 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

    </style>
</head>
<body>
<div class="container">
    <h2>Edit Patient Info</h2>
    <form method="POST">
        <div class="form-row">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($patient['name']); ?>" required>
                <i class="fas fa-user"></i>
            </div>
            <div class="form-group">
                <label for="address">Full Address (Barangay):</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Barangay" onkeyup="searchAddress()" value="<?php echo htmlspecialchars($patient['address']); ?>" required>
                <div id="addressSuggestions" class="suggestions-box"></div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($patient['dob']); ?>" required onchange="computeAge()">
            </div>
            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($patient['age']); ?>" required readonly>
                <i class="fas fa-calendar-alt"></i>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="sex">Sex</label>
                <select id="sex" name="sex" required>
                    <option value="male" <?php echo ($patient['sex'] == 'male' ? 'selected' : ''); ?>>Male</option>
                    <option value="female" <?php echo ($patient['sex'] == 'female' ? 'selected' : ''); ?>>Female</option>
                </select>
                <i class="fas fa-venus-mars"></i>
            </div>
            <div class="form-group">
                <label for="contactnum">Contact Number</label>
                <input type="text" id="contactnum" name="contactnum" value="<?php echo htmlspecialchars($patient['contactnum']); ?>" required>
                <i class="fas fa-phone"></i>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="civil_status">Civil Status</label>
                <select id="civil_status" name="civil_status" required>
                    <option value="Single" <?php echo ($patient['civil_status'] == 'Single' ? 'selected' : ''); ?>>Single</option>
                    <option value="Married" <?php echo ($patient['civil_status'] == 'Married' ? 'selected' : ''); ?>>Married</option>
                    <option value="Widowed" <?php echo ($patient['civil_status'] == 'Widowed' ? 'selected' : ''); ?>>Widowed</option>
                    <option value="Divorced" <?php echo ($patient['civil_status'] == 'Divorced' ? 'selected' : ''); ?>>Divorced</option>
                </select>
                <i class="fas fa-heart"></i>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($patient['email']); ?>" required>
                <i class="fas fa-user"></i>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
    </form>
</div>

<script>
// List of Barangays in Nasugbu, Batangas
const barangays = [
    'Aga', 'Balaytigui', 'Banilad', 'Barangay 1', 'Barangay 10', 'Barangay 11', 'Barangay 12', 
    'Barangay 2', 'Barangay 3', 'Barangay 4', 'Barangay 5', 'Barangay 6', 'Barangay 7', 'Barangay 8', 
    'Barangay 9', 'Bilaran', 'Bucana', 'Bulihan', 'Bunducan', 'Butucan', 'Calayo', 'Catandaan', 
    'Cogunan', 'Dayap', 'Kaylaway', 'Kayrilaw', 'Latag', 'Looc', 'Lumbangan', 'Malapad na Bato', 
    'Mataas na Pulo', 'Maugat', 'Munting Indan', 'Natipuan', 'Pantalan', 'Papaya', 'Putat', 'Reparo', 
    'Talangan', 'Tumalim', 'Utod', 'Wawa'
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

// Function to compute age based on Date of Birth
function computeAge() {
    const dob = new Date(document.getElementById("dob").value);
    const today = new Date();
    let age = today.getFullYear() - dob.getFullYear();
    const month = today.getMonth() - dob.getMonth();

    if (month < 0 || (month === 0 && today.getDate() < dob.getDate())) {
        age--;
    }

    document.getElementById("age").value = age; // Set calculated age
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

</body>
</html>




     <!-- Modal HTML -->
     <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Success!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Patient details have been successfully updated.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

 

    <script>
        // If patient info updated successfully, show the modal
        <?php if(isset($_GET['update_success'])): ?>
            $('#successModal').modal('show');
            setTimeout(function() {
                $('#successModal').modal('hide');
            }, 3000); // Close modal after 3 seconds
        <?php endif; ?>
    </script>





                          <!-- jQuery -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>