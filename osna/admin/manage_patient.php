
<?php
// Start session
session_start();
include '../db.php'; // Ensure the correct path to db.php

// Redirect to login if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: /osna/admin/login.php");
    exit();
}

$username = $_SESSION['username'];

// Use PostgreSQL's parameterized query to prevent SQL injection
$sql = "SELECT name FROM admin_log WHERE username = $1";
$result = pg_query_params($con, $sql, array($username));

$name = "Unknown"; // Default value
if ($result) {
    $user = pg_fetch_assoc($result);
    if ($user) {
        $name = $user['name'];
    }
}

// Free the result resource
pg_free_result($result);

?>

<?php
// Include your database connection script
include 'db.php';

$limit = 8;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch data from the table
$sql = "SELECT id, username, name, email, guardian, address FROM patient_info ORDER BY id DESC LIMIT $1 OFFSET $2";
$result = pg_query_params($con, $sql, array($limit, $offset));

// Total rows in the table
$sql_total = "SELECT COUNT(*) FROM patient_info";
$result_total = pg_query($con, $sql_total);
$row_total = pg_fetch_row($result_total);
$total_rows = $row_total[0];
$total_pages = ceil($total_rows / $limit);

// Free result resources
pg_free_result($result_total);
pg_free_result($result);
?>

<?php
// Handle form submissions
include 'db.php'; // Include your database connection script

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];

    switch ($action) {
        case 'update':
            // Update patient record
            $id = $_POST['id'];
            $username = $_POST['username'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $guardian = $_POST['guardian'];
            $address = $_POST['address'];

            // Prepare and execute update statement
            $sql = "UPDATE patient_info SET username = $1, name = $2, email = $3, guardian = $4, address = $5 WHERE id = $6";
            $result = pg_query_params($con, $sql, array($username, $name, $email, $guardian, $address, $id));

            echo $result ? "UpdateSuccess" : "UpdateError: " . pg_last_error($con);
            break;

        case 'delete':
            // Delete patient record
            $id = $_POST['id'];

            // Prepare and execute delete statement
            $sql = "DELETE FROM patient_info WHERE id = $1";
            $result = pg_query_params($con, $sql, array($id));

            echo $result ? "DeleteSuccess" : "DeleteError: " . pg_last_error($con);
            break;

        default:
            echo "NoValidAction";
            break;
    }

    // Close the PostgreSQL connection
    pg_close($con);
} else {
    echo "InvalidRequestMethod";
}
?>


<!DOCTYPE html>
<html lang="en">
    
<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:20 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Manage Patient</title>
		

		  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
		    <!-- Include FontAwesome for icons -->
		    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
		    
		    <!-- Include Bootstrap JS and jQuery for modal functionality -->
		    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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

                            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

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
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">Patient Informantion</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="admin_dash.php">Dashboard</a></li>
									<li class="breadcrumb-item active">Edit | Delete</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->

                    	<!-- /Table for updating -->


                        <div class="container mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>P_ID</th>
                                    <th>Username</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Guardian</th>
                                    <th>Address</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <style>
                                   

                                </style>
                                                                <?php
                                // Query the database for patient records
                                $sql = "SELECT id, username, name, email, guardian, address FROM patient_info ORDER BY id DESC";
                                $result = pg_query($con, $sql); // Execute query using pg_query

                                if (pg_num_rows($result) > 0) {
                                    while ($row = pg_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                                        echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['guardian']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['address']) . "</td>";

                                        echo "<td>";
                                        echo "<button class='btn btn-warning btn-sm' style='background-color: #295F98; color: white; border-color: blue;' data-toggle='modal' data-target='#editModal' data-id='" . $row['id'] . "' data-username='" . $row['username'] . "' data-name='" . $row['name'] . "' data-email='" . $row['email'] . "' data-guardian='" . $row['guardian'] . "' data-address='" . $row['address'] . "'><i class='fas fa-edit'></i></button> ";
                                        echo "<button class='btn btn-danger btn-sm' onclick='deletePatient(" . $row['id'] . ")'><i class='fas fa-trash'></i></button>";

                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No data found</td></tr>";
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Patient</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm">
                    <div class="modal-body">
                        <input type="hidden" id="patientId" name="id">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="guardian">Guardian</label>
                            <input type="text" class="form-control" id="guardian" name="guardian" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // When the edit button is clicked
    $('#editModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id = button.data('id');
        var username = button.data('username');
        var name = button.data('name');
        var email = button.data('email');
        var guardian = button.data('guardian');
        var address = button.data('address');
        

        // Populate the form fields with the data
        var modal = $(this);
        modal.find('#patientId').val(id);
        modal.find('#username').val(username);
        modal.find('#name').val(name);
        modal.find('#email').val(email);
        modal.find('#guardian').val(guardian);
        modal.find('#address').val(address);
        
    });

    // When the form is submitted
    $('#editForm').on('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting the default way

        $.ajax({
            url: 'manage_patient.php', // URL of the PHP script that handles both update and delete
            type: 'POST',
            data: $(this).serialize() + '&action=update',
            success: function(response) {
                // Handle the response from the server (e.g., show a success message)
                if (response.includes('Success')) {
                    alert('Patient information updated successfully!');
                    $('#editModal').modal('hide');
                    location.reload(); // Refresh the page to reflect the changes
                } else {
                    alert('An error occurred: ' + response);
                }
            },
            error: function() {
                alert('An error occurred while updating the information.');
            }
        });
    });
});

function deletePatient(id) {
    if (confirm('Are you sure you want to delete this record?')) {
        $.ajax({
            url: 'delete.php', // URL of the PHP script that handles the deletion
            type: 'POST',
            data: { id: id },
            success: function(response) {
                // Handle the response from the server (e.g., show a success message)
               
                location.reload(); // Refresh the page to reflect the changes
            },
            error: function() {
                alert('An error occurred while deleting the record.');
            }
        });
    }
}
</script><script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // When the edit button is clicked
    $('#editModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id = button.data('id');
        var username = button.data('username');
        var name = button.data('name');
        var email = button.data('email');
        var guardian = button.data('guardian');
        var address = button.data('address');
        
        // Populate the form fields with the data
        var modal = $(this);
        modal.find('#patientId').val(id);
        modal.find('#username').val(username);
        modal.find('#name').val(name);
        modal.find('#email').val(email);
        modal.find('#guardian').val(guardian);
        modal.find('#address').val(address);
        
    });

    // When the form is submitted
    $('#editForm').on('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting the default way

        $.ajax({
            url: 'manage_patient.php', // URL of the PHP script that handles both update and delete
            type: 'POST',
            data: $(this).serialize() + '&action=update',
            success: function(response) {
                // Handle the response from the server (e.g., show a success message)
                if (response.includes('Success')) {
                  
                    $('#editModal').modal('hide');
                    location.reload(); // Refresh the page to reflect the changes
                } else {
                    alert('An error occurred: ' + response);
                }
            },
            error: function() {
                alert('An error occurred while updating the information.');
            }
        });
    });

    // Function to delete a patient
    function deletePatient(id) {
        if (confirm('Are you sure you want to delete this record?')) {
            $.ajax({
                url: 'manage_patient.php', // URL of the PHP script that handles both update and delete
                type: 'POST',
                data: { id: id, action: 'delete' },
                success: function(response) {
                    // Handle the response from the server (e.g., show a success message)
                    if (response.includes('Success')) {
                        
                        location.reload(); // Refresh the page to reflect the changes
                    } else {
                        alert('An error occurred: ' + response);
                    }
                },
                error: function() {
                    alert('An error occurred while deleting the record.');
                }
            });
        }
    }
});
</script>


    


		

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Bootstrap JS (if using Bootstrap) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


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
