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
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Manage Patient</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/opd.png">
</head>
<body>
    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <a href="" class="logo">
                    <img src="assets/img/opd.png" alt="Logo">
                </a>
            </div>
            <div class="top-nav-search"></div>
            <a href="javascript:void(0);" id="toggle_btn"><i class="fe fe-text-align-left"></i></a>
        </div>

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
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Patient Information</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="admin_dash.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Edit | Delete</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Table for updating -->
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
                                            <?php
                                            // Query the database for patient records
                                            $sql = "SELECT id, username, name, email, guardian, address FROM patient_info ORDER BY id DESC";
                                            $result = pg_query($con, $sql);

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
                                        <input type="email" class="form-control" id="email" name="email" required>
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
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        $(document).ready(function() {
            // Populate modal with data when triggered by the edit button
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

            // Submit the update form
            $('#editForm').on('submit', function(event) {
                event.preventDefault();
                $.ajax({
                    url: 'manage_patient.php', // The PHP script for handling update
                    type: 'POST',
                    data: $(this).serialize() + '&action=update',
                    success: function(response) {
                        if (response.includes('Success')) {
                            alert('Patient information updated successfully!');
                            $('#editModal').modal('hide');
                            location.reload(); // Refresh the page
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

        // Function to delete a patient
        function deletePatient(id) {
            if (confirm('Are you sure you want to delete this patient?')) {
                $.ajax({
                    url: 'manage_patient.php', // The PHP script for handling deletion
                    type: 'POST',
                    data: { id: id, action: 'delete' },
                    success: function(response) {
                        if (response.includes('DeleteSuccess')) {
                            alert('Patient deleted successfully!');
                            location.reload(); // Refresh the page
                        } else {
                            alert('An error occurred while deleting the record: ' + response);
                        }
                    },
                    error: function() {
                        alert('An error occurred while deleting the record.');
                    }
                });
            }
        }
    </script>
</body>
</html>
