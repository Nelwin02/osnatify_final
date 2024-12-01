<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Manage Medicines</title>
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

 <!-- DataTables CSS -->
 <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    
    <!-- Bootstrap CSS (optional for styling) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

        <?php
        session_start();
        include 'db.php'; 

        if (!isset($_SESSION['username'])) {
            header("Location: login.php");
            exit();
        }

        $username = $_SESSION['username'];

        $sql = "SELECT doctor_name, doctor_image FROM doctor_log WHERE username = '$username'";
        $result = mysqli_query($con, $sql);

        if ($result) {
            $doctor = mysqli_fetch_assoc($result);
            if ($doctor) {
                $name = $doctor['doctor_name'];
                $image = $doctor['doctor_image'];
            } else {
                $name = "Unknown";
                $image = "default.png"; 
            }
        } else {
            $name = "Unknown";
            $image = "default.png"; 
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $symptoms = $_POST['symptoms'];
            $predicted_disease = $_POST['predicted_disease'];
            $prescription = $_POST['prescription'];
            $medication = $_POST['medication'];
            $disease = $_POST['disease'];
        
            
            $sql = "UPDATE patient_info 
                    SET symptoms = ?, 
                        predicted_disease = ?, 
                        prescription = ?, 
                        medication = ?, 
                        disease = ?
                    WHERE username = ?";
        
            if ($stmt = mysqli_prepare($con, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssssss", $symptoms, $predicted_disease, $prescription, $medication, $disease, $username);
        
                if (mysqli_stmt_execute($stmt)) {
                    echo "Data successfully updated.";
                } else {
                    echo "Error updating data: " . mysqli_error($con);
                }
        
                mysqli_stmt_close($stmt);
            } else {
                echo "Error preparing statement: " . mysqli_error($con);
            }
        }
        
        ?>

        <?php

        include 'db.php';


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
            $username = $_POST['username'];
            $predicted_disease = $_POST['predicted_disease'];
            $predicted_prescription = $_POST['predicted_prescription'];
            $frequency = $_POST['frequency'];
            $firstTake = $_POST['first_take'];
            $secondTake = $_POST['second_take'];
            $thirdTake = $_POST['third_take'];
            $fourthTake = $_POST['fourth_take'];
            $fifthTake = $_POST['fifth_take'];

        
            $stmt = $con->prepare("INSERT INTO doctor_confirm (username, predicted_disease, predicted_prescription, frequency, first_take, second_take, third_take, fourth_take, fifth_take) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", $username, $predicted_disease, $predicted_prescription, $frequency, $firstTake, $secondTake, $thirdTake, $fourthTake, $fifthTake);

            
            if ($stmt->execute()) {
                echo "Prescription added successfully";
            } else {
                echo "Error: " . $stmt->error;
            }

            
           
        }
        ?>

        <?php


        $sql = "SELECT id, username, name, address, age, dob, sex, weight, height, bloodpressure, heartrate, symptoms, predicted_disease, predicted_prescription, predicted_treatment FROM patient_info order by id desc";
        $result = mysqli_query($con, $sql);
        ?>

<?php


// Your existing code to fetch and display other content

// Initialize message variable
$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Clear the message after displaying it
} elseif (isset($_SESSION['error'])) {
    $message = $_SESSION['error'];
    unset($_SESSION['error']); // Clear the error after displaying it
}
?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var message = "<?php echo addslashes($message); ?>"; // Escape the message for JavaScript
    if (message) {
        document.getElementById('modalBody').innerText = message; // Set the message in the modal body
        $('#notificationModal').modal('show'); // Show the modal if there's a message
    }
});
</script>


        





   
</head>
<body>
    <style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    display: flex; /* Aligns sidebar and content */
    transition: all 0.3s; /* Smooth transition for sidebar toggle */
}

#menu-toggle {
    display: none; /* Hide checkbox */
}

.sidebar {
    width: 200px; /* Sidebar width */
    height: 100vh; /* Full height */
    background: #2c3e50; /* Sidebar background color */
    position: fixed; /* Fixed position */
    left: -250px; /* Initially hide off-screen */
    transition: left 0.3s; /* Smooth transition */
    padding: 20px; /* Padding inside the sidebar */
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1); /* Shadow for depth */
}

#menu-toggle:checked + .sidebar {
    left: 0; /* Show sidebar when checked */
}

#menu-toggle:checked ~ .main-content {
    margin-left: 260px; /* Space for sidebar when it is shown */
}

.main-content {
    margin-left: 0; /* No margin when sidebar is hidden */
    padding: 20px; /* Padding for content */
    flex-grow: 1; /* Allow content to fill space */
    transition: margin-left 0.3s; /* Smooth transition for content */
    display: flex; /* Use flex for main content */
    flex-direction: column; /* Stack content vertically */
}

.side-header {
    text-align: center;
    margin-bottom: 20px; /* Space below header */
}

.profile {
    text-align: center;
    color: #ecf0f1; /* Profile text color */
}

.profile-img {
    width: 70px; /* Profile image size */
    border-radius: 50%; /* Circular profile image */
    margin-bottom: 10px; /* Space below image */
}

.side-menu ul {
    list-style: none; /* Remove default bullet points */
    padding: 0; /* Remove padding */
}

.side-menu li {
    margin: 15px 0; /* Space between menu items */
}

.side-menu a {
    text-decoration: none; /* Remove underline from links */
    color: #ecf0f1; /* Menu item color */
    display: flex; /* Flexbox for aligning */
    align-items: center; /* Center align icon and text */
    padding: 10px 15px; /* Padding for each link */
    border-radius: 5px; /* Rounded corners */
    transition: background 0.3s; /* Smooth hover effect */
}

.side-menu a:hover {
    background: #34495e; /* Background color on hover */
}

.side-menu .active {
    background: #2980b9; /* Active menu item color */
}

header {
    display: flex; /* Flexbox for header layout */
    justify-content: space-between; /* Space between items */
    align-items: center; /* Center items vertically */
    background: #ecf0f1; /* Header background */
    padding: 10px 20px; /* Padding in header */
    box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1); /* Shadow for depth */
}

.header-content {
    display: flex;
    align-items: left; /* Center header items vertically */
}

.header-menu {
    display: flex;
    align-items: center; /* Center header menu items */
}

.notify-icon {
    position: relative; /* Position for notification badge */
    margin-left: 20px; /* Space between icons */
}

.notify {
    position: absolute; /* Absolute positioning for badge */
    top: -10px; /* Position badge */
    right: -10px; /* Position badge */
    background: red; /* Badge background */
    color: white; /* Badge text color */
    border-radius: 50%; /* Circular badge */
    padding: 5px; /* Padding for badge */
    font-size: 12px; /* Font size for badge */
}

.user {
    display: flex; /* Flexbox for user section */
    align-items: center; /* Center user items vertically */
    margin-left: 20px; /* Space between user and other items */
}

.bg-img {
    width: 40px; /* User image size */
    height: 40px; /* User image size */
    border-radius: 50%; /* Circular image */
    background-size: cover; /* Cover image */
    background-position: center; /* Center image */
    margin-right: 10px; /* Space between image and text */
}

.card {
    background: white; /* Card background */
    border-radius: 8px; /* Rounded corners */
    padding: 20px; /* Padding inside card */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Shadow for depth */
    margin: 20px 0; /* Space above and below card */
}

.card-head {
    display: flex; /* Flexbox for card header */
    justify-content: space-between; /* Space between items */
    align-items: center; /* Center items vertically */
}

.card-progress {
    margin-top: 10px; /* Space above progress section */
}

.card-indicator {
    background: #f0f0f0; /* Background for progress indicator */
    border-radius: 5px; /* Rounded corners */
    overflow: hidden; /* Hide overflow for progress */
}

.indicator {
    height: 5px; /* Height of progress indicator */
    background: #3498db; /* Progress color */
}

/* Responsive Design */
@media (max-width: 768px) {
    .sidebar {
        width: 200px; /* Adjust sidebar width for small screens */
        position: absolute; /* Make sidebar absolute for small screens */
        left: -200px; /* Hide off-screen initially */
    }

    #menu-toggle:checked + .sidebar {
        left: 0; /* Show sidebar when checked */
    }

    .main-content {
        margin-left: 0; /* No margin when sidebar is hidden */
        padding: 10px; /* Reduce padding for small screens */
    }

    .header-content {
        padding: 10px; /* Reduce padding for small screens */
        flex-direction: column; /* Stack header items vertically */
        align-items: center; /* Center header items */
    }

    .card {
        margin: 10px 0; /* Less margin for cards on small screens */
        width: 90%; /* Set card width */
        max-width: 400px; /* Max width for cards */
    }

    /* Adjust layout for the main content */
    .main-content {
        display: flex; /* Use flexbox for main content */
        flex-direction: column; /* Stack elements vertically */
        align-items: center; /* Center content */
    }

    /* Make table responsive */
    table {
        width: 100%; /* Full width for tables */
        border-collapse: collapse; /* Remove gaps between cells */
    }

    th, td {
        padding: 8px; /* Padding for table cells */
        text-align: left; /* Left-align text */
        border: 1px solid #ddd; /* Add border to cells */
    }
}


    </style>
         <input type="checkbox" id="menu-toggle" hidden checked> <!-- Checked by default -->
<div class="sidebar">
    <div class="side-header text-center mb-3">
        <span><img src="img/opd.png" alt="Logo" width="100px"></span>
    </div>
    
    <div class="side-content">
        <div class="profile text-center mb-4">
            <div>
                <img src="../doctor/Images/<?php echo htmlspecialchars($image); ?>" alt="Doctor Image" class="profile-img bg-img">
            </div>
            <h4>Welcome,</h4>
            <small><?php echo htmlspecialchars($name); ?></small>
        </div>
        
        <div class="side-menu">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="doctor_dash.php" class="nav-link active">
                        <span class="las la-home"></span> &nbsp;
                        <small style="font-size: 15px;">Dashboard</small>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="manage_patient.php" class="nav-link">
                    <span class="las la-stethoscope"></span> &nbsp;
                        <small style="font-size: 15px;"> Prescription</small>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
    <div class="main-content">
        <header class="d-flex justify-content-between align-items-center p-3 bg-light">
            <div>
                <label for="menu-toggle" class="toggle-label">
                    <span class="las la-bars"></span>
                </label>
            </div>
            
            <div class="header-menu d-flex align-items-center">
                <div class="notify-icon position-relative">
                   
                </div>
                
                <div class="user d-flex align-items-center ml-3">
                    <a href="profile.php" class="d-flex align-items-center">
                        <div class="bg-img" style="background-image: url('../doctor/Images/<?php echo htmlspecialchars($image); ?>');" class="rounded-circle"></div>
                    </a>
                    <a href="../doctor/login.php" class="ml-2">
                      
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </header>
        
        <main class="p-4">
            <div class="page-header mb-4">
                <h1>Manage Prescription</h1>
                <small>Home / Prescription</small>
            </div>

            <!-- Modal Structure -->
<div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content1">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Success!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Message will be injected here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


            <style>
.table-container {
    max-width: 100%; /* Ensure the container is full width */
    overflow-x: auto; /* Enable horizontal scrolling if needed */
    margin: 20px 0;
}

table {
    width: 100%; /* Full width of parent container */
    border-collapse: collapse; /* Merge border spacing */
    font-family: Arial, sans-serif; /* Change font */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Add subtle shadow */
    table-layout: fixed; /* Fixed layout for equal column widths */
}

th {
    background-color: #007bff; /* Header background color */
    color: white; /* Header text color */
    padding: 12px; /* Padding around header cells */
    text-align: center;
}

td {
    padding: 10px; /* Padding around data cells */
    border-bottom: 1px solid #ddd; /* Bottom border for rows */
    text-align: center; /* Center align text in data cells */
}

tr:hover {
    background-color: #f1f1f1; /* Highlight row on hover */
}

.action-btn {
    background-color: #28a745; /* Green background for buttons */
    color: white; /* White text */
    border: none; /* No border */
    padding: 10px 15px; /* Padding around the button */
    border-radius: 5px; /* Rounded corners */
    cursor: pointer; /* Pointer cursor on hover */
    transition: background-color 0.3s ease; /* Smooth background transition */
}

.action-btn:hover {
    background-color: #218838; /* Darker green on hover */
}

/* Additional adjustments for wider columns */
th:nth-child(1), td:nth-child(1) {
    width: 20%; /* 20% for Username */
}

th:nth-child(2), td:nth-child(2) {
    width: 25%; /* 25% for Symptoms */
}

th:nth-child(3), td:nth-child(3) {
    width: 25%; /* 25% for Diagnosis */
}

th:nth-child(4), td:nth-child(4) {
    width: 25%; /* 25% for Prescription */
}

th:nth-child(5), td:nth-child(5) {
    width: 25%; /* 25% for Treatment */
}

th:nth-child(6), td:nth-child(6) {
    width: 10%; /* 10% for Action */
}

@media (max-width: 768px) {
    th, td {
        font-size: 14px; /* Reduce font size on smaller screens */
        padding: 8px; /* Reduce padding on smaller screens */
    }
}



            </style>
        
        <div class="page-content">
        <div class="table-responsive">
    <!-- Pending Status Table -->
    <?php
include 'db.php';

// SQL query to count patients with pending status
$sql = "SELECT COUNT(*) AS pending_count FROM patient_info WHERE status = 'pending'";
$result = $con->query($sql);



// Check if there are results
if ($result->num_rows > 0) {
    // Fetch the count
    $row = $result->fetch_assoc();
    $pendingCount = $row['pending_count'];
    
    // Display the count
    echo '<span style="font-size: 24px;">Patients with pending status: <span style="color: red; font-weight: bold;">' . $pendingCount . '</span></span>';

} else {
    echo "No pending patients found.";
}

?>

    <table class="table table-striped table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th class="text-center">Username</th>
                <th class="text-center">Symptoms</th>
                <th class="text-center">Diagnosis</th>
                <th class="text-center">Prescription</th>
                <th class="text-center">Treatment</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Query for Pending Status
            $pendingResult = mysqli_query($con, "SELECT * FROM patient_info WHERE status = 'pending' order by id desc limit 1");
            if ($pendingResult && mysqli_num_rows($pendingResult) > 0) {
                while ($row = mysqli_fetch_assoc($pendingResult)) {
                    $predicted_disease = preg_replace('/\bdiagnosis:\s*/i', '', htmlspecialchars($row['predicted_disease']));
                    $predicted_prescription = preg_replace('/\bprescription:\s*/i', '', htmlspecialchars($row['predicted_prescription']));
                    $predicted_treatment = preg_replace('/\btreatment:\s*/i', '', htmlspecialchars($row['predicted_treatment']));
                    echo '<tr>';
                    echo '<td class="text-center">' . htmlspecialchars($row['username']) . '</td>';
                    echo '<td class="text-center">' . htmlspecialchars($row['symptoms']) . '</td>';
                    echo '<td class="text-center">' . $predicted_disease . '</td>';
                    echo '<td class="text-center">' . $predicted_prescription . '</td>';
                    echo '<td class="text-center">' . $predicted_treatment . '</td>';
                    echo '<td class="text-center">';
                    echo '<button class="btn btn-primary action-btn approve-btn" 
                                data-username="' . htmlspecialchars($row['username']) . '"
                                data-patient-name="' . htmlspecialchars($row['name']) . '"
                                data-symptoms="' . htmlspecialchars($row['symptoms']) . '"
                                data-predicted-disease="' . $predicted_disease . '"
                                data-predicted-prescription="' . $predicted_prescription . '"
                                data-predicted-medicines="' . $predicted_treatment . '"
                                data-age="' . htmlspecialchars($row['age']) . '"
                                data-dob="' . htmlspecialchars($row['dob']) . '"
                                data-weight="' . htmlspecialchars($row['weight']) . '"
                                data-height="' . htmlspecialchars($row['height']) . '"
                                data-bloodpressure="' . htmlspecialchars($row['bloodpressure']) . '"
                                data-heartrate="' . htmlspecialchars($row['heartrate']) . '"
                                data-address="' . htmlspecialchars($row['address']) . '"> 
                                <i class="las la-plus"></i>
                            </button>';
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="6" class="text-center">No Pending Records</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>
        </div>
        <br><br><br><br>
        <div class="page-content">
<div class="table-responsive">
    <!-- Approved Status Table -->
    <h3>Done Prescribe&nbsp; </h3>
    <table class="table table-striped table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th class="text-center">Username</th>
                <th class="text-center">Symptoms</th>
                <th class="text-center">Diagnosis</th>
                <th class="text-center">Prescription</th>
                <th class="text-center">Treatment</th>
               
            </tr>
        </thead>
        <tbody>
            <?php
            // Query for Approved Status
            $approvedResult = mysqli_query($con, "SELECT * FROM patient_info WHERE status = 'approved' order by id desc");
            if ($approvedResult && mysqli_num_rows($approvedResult) > 0) {
                while ($row = mysqli_fetch_assoc($approvedResult)) {
                    $predicted_disease = preg_replace('/\bdiagnosis:\s*/i', '', htmlspecialchars($row['predicted_disease']));
                    $predicted_prescription = preg_replace('/\bprescription:\s*/i', '', htmlspecialchars($row['predicted_prescription']));
                    $predicted_treatment = preg_replace('/\btreatment:\s*/i', '', htmlspecialchars($row['predicted_treatment']));
                    echo '<tr>';
                    echo '<td class="text-center">' . htmlspecialchars($row['username']) . '</td>';
                    echo '<td class="text-center">' . htmlspecialchars($row['symptoms']) . '</td>';
                    echo '<td class="text-center">' . $predicted_disease . '</td>';
                    echo '<td class="text-center">' . $predicted_prescription . '</td>';
                    echo '<td class="text-center">' . $predicted_treatment . '</td>';
                    echo '<td class="text-center">';
                  
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="6" class="text-center">No Approved Records</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>



<!-- Add Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">


            
            <style>
           

.action-btn {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%; /* Button fills the width of the cell */
    height: 100%; /* Button fills the height of the cell */
    background-color: transparent; /* Transparent background */
    border: none; /* No border */
    cursor: pointer; 
    padding: 0; /* No padding */
    margin: 0; /* No margin to avoid internal gaps */
    box-sizing: border-box; /* Ensures padding/border are included in the size */
}

@media (max-width: 768px) {
    .action-btn {
        width: 90%; /* Adjust width on smaller screens */
        padding: 8px; /* Reduce padding for smaller screens */
    }
}


.action-btn i {
    font-size: 1.5rem; /* Adjust the icon size */
    color: #000; /* Set icon color */
}

            </style>
        </table>
    </div>
</div>
<style>
.success {
    color: green;
    font-weight: bold;
}

.error {
    color: red;
    font-weight: bold;
}
</style>




<script>

    // Handle edit button click
document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function () {
        const username = this.getAttribute('data-username');
        const disease = this.getAttribute('data-predicted-disease');
        const prescription = this.getAttribute('data-predicted-prescription');
        const treatment = this.getAttribute('data-predicted-treatment');

        // Populate the modal fields
        document.getElementById('editUsername').value = username;
        document.getElementById('predictedDisease').value = disease;
        document.getElementById('predictedPrescription').value = prescription;
        document.getElementById('predictedTreatment').value = treatment;
    });
});

</script>

<script>
    // Function to open the modal
function openModal(modalId) {
    document.getElementById(modalId).style.display = "block";
}

// Function to close the modal
function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none";
}

// Event listeners for opening modals
document.getElementById("openPrescriptionModal").addEventListener("click", function() {
    openModal('prescriptionModal');
});

// Close modals when clicking outside of them
window.onclick = function(event) {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        if (event.target === modal) {
            closeModal(modal.id);
        }
    });
}

// Close modals when clicking the close button
const closeButtons = document.querySelectorAll('.close-btn');
closeButtons.forEach(btn => {
    btn.addEventListener('click', function() {
        closeModal(btn.parentElement.parentElement.id);
    });
});

</script>


<!-- Modal -->
    <div id="approvalModal" class="modal">
        <div class="modal-content">
        <span class="close-btn" onclick="closeModal('approvalModal')" style="font-size: 36px; position: absolute; right: 20px; top: 20px; cursor: pointer;">&times;</span>

            <h2 style="text-align: center;">Prescribing Patient</h2>
            <label for="doctor_name" style="text-align: center; font-size: 12px;">Prescriber: <?php echo htmlspecialchars($name); ?></label><br>
            
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: center; color:#000;">Name</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: center; color:#000;">Age</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: center; color:#000;">DoB</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: center; color:#000;">Address</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center; color: red;" id="patientName"></td>
                        <td style="border: 1px solid #ddd; padding: 8px; color: black; text-align: center; font-weight: bold; font-size: 14px;" id="age"></td>
                        <td style="border: 1px solid #ddd; padding: 8px; color: black; text-align: center; font-weight: bold; font-size: 14px;" id="dob"></td>
                        <td style="border: 1px solid #ddd; padding: 8px; color: black; text-align: center; font-weight: bold; font-size: 14px;" id="address"></td>
                    </tr>
                </tbody>
            </table>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: center; color:#000;">Weight</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: center; color:#000;">Height</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: center; color:#000;">BP</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: center; color:#000;">Heart Rate</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 8px; color: black; text-align: center;" id="weight"></td>
                        <td style="border: 1px solid #ddd; padding: 8px; color: black; text-align: center; font-weight: bold;" id="height"></td>
                        <td style="border: 1px solid #ddd; padding: 8px; color: black; text-align: center; font-weight: bold;" id="bloodpressure"></td>
                        <td style="border: 1px solid #ddd; padding: 8px; color: black; text-align: center; font-weight: bold;" id="heartrate"></td>
                    </tr>
                </tbody>
            </table>
            

            <form id="approveForm" method="post" action="addPrescription.php">
                <input type="hidden" name="username" id="modalUsername">
            
                <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="font-weight: bold; color:#000;">Symptoms</td>
            <td>
                <input type="text" id="symptomsInput" name="symptoms" readonly style="border: 1px solid white; padding: 5px; width: 100%;" />
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold; color:#000;">Diagnosis</td>
            <td>
                <input type="text" id="predictedDiseaseInput" name="predicted_disease" readonly style="border: 1px solid white; padding: 5px; width: 100%;" />
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold; color:#000;">Treatment</td>
            <td>
                <input type="text" id="predictedTreatmentInput" name="predicted_treatment" readonly style="border: 1px solid white; padding: 5px; width: 100%;" />
            </td>
        </tr>
    </table>
    <!-- Guide Label -->
    <label for="guide" style="font-weight: bold; font-size: 1.2rem; display: block; margin-bottom: 10px;">Prescription Guide:</label>

    <!-- Red Bullet Points with Text -->
    <ul style="list-style-type: none; padding-left: 20px;">
        <li style="color: red; font-size: 1rem; margin-bottom: 5px;">
            <span style="color: black; font-weight: bold;">&#8226;</span> Confirm the <strong style="color: grey; font-weight: bold;">Prescription</strong> via edit and save.
        </li>
        <li style="color: red; font-size: 1rem; margin-bottom: 5px;">
            <span style="color: red; font-weight: bold;">&#8226;</span> Set the <strong style="color: grey; font-weight: bold;">Duration (Days)</strong> to take the prescription.
        </li>
        <li style="color: red; font-size: 1rem; margin-bottom: 5px;">
            <span style="color: red; font-weight: bold;">&#8226;</span> Click <strong style="color: grey; font-weight: bold;">Set Frequency</strong> to set times per day to take the prescription, then click OK.
        </li>
        <li style="color: red; font-size: 1rem;">
            <span style="color: red; font-weight: bold;">&#8226;</span> Now, you will see the <strong style="color: grey; font-weight: bold;">Prescription Details</strong> and can approve.
        </li>
    </ul>


                <div class="form-group" style="margin-bottom: 20px;">
        <label for="predicted_prescription" style="font-weight: bold; font-size: 1.2rem;">Prescription</label>
        
        <div class="input-group" style="display: flex; align-items: center; border: 1px solid #ccc; border-radius: 5px; overflow: hidden;">
            <input type="text" id="predictedPrescriptionInput" name="predicted_prescription" readonly style="border: none; padding: 10px; width: 100%; font-size: 1rem; color: #333;" />
            <div class="input-group-append" style="display: flex;">
                <button class="btn" type="button" id="editPrescription" style="border: none; background-color: #f0f0f0; padding: 10px; cursor: pointer; display: flex; align-items: center; transition: background-color 0.3s;">
                    <i class="la la-edit" style="margin-right: 5px;"></i> Edit
                </button>
                <button class="btn" type="button" id="savePrescription" style="display: none; border: none; background-color: #f0f0f0; padding: 10px; cursor: pointer; display: flex; align-items: center; transition: background-color 0.3s;">
                    <i class="la la-save" style="margin-right: 5px;"></i> Save
                </button>
            </div>
        </div>
    </div>
    <br><br>
    <div class="form-group">
        <label style="font-weight: bold;" for="duration">SET DURATION (Days)</label>
        <input  type="number" name="duration" id="duration" required min="1" style="width: 10%; text-align:center" />
    </div><br><br>

    <style>
    
        .btn:hover {
            background-color: #e0e0e0; /* Change color on hover */
        }

        .input-group {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Adding subtle shadow for depth */
        }

        /* Optional: Responsive design adjustments */
        @media (max-width: 768px) {
            .form-group {
                margin-bottom: 15px;
            }
        }
    </style>
    </style>

    <script>
    document.getElementById('editPrescription').addEventListener('click', function() {
        // Enable the input field for editing
        const inputField = document.getElementById('predictedPrescriptionInput');
        inputField.removeAttribute('readonly');
        inputField.style.border = "1px solid #ccc"; // Optional: Add a visible border when editing

        // Hide the edit button and show the save button
        document.getElementById('editPrescription').style.display = 'none';
        document.getElementById('savePrescription').style.display = 'inline-block';
    });

    document.getElementById('savePrescription').addEventListener('click', function() {
        const prescription = document.getElementById('predictedPrescriptionInput').value;
        const patientId = 123; // You will need to dynamically pass the correct patient ID or username

        if (prescription) {
            // Send the updated prescription to the server via AJAX
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "update.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert('Prescription Edited, Proceed to Duration!');

                        // Make the input field readonly again
                        inputField.setAttribute('readonly', true);
                        inputField.style.border = "1px solid white";

                        // Switch buttons back
                        document.getElementById('editPrescription').style.display = 'inline-block';
                        document.getElementById('savePrescription').style.display = 'none';
                    } else {
                        alert('Failed to update prescription.');
                    }
                }
            };
            xhr.send("predicted_prescription=" + encodeURIComponent(prescription) + "&patient_id=" + patientId);
        } else {
            alert('Please enter a prescription.');
        }
    });

    </script>

            

                <div class="form-group">
                    
                    <button type="button" id="openPrescriptionModal" style="color:#f0f4f8; background-color:#0071bc;" class="btn">Frequency (times per day)</button>
                </div>

                    <!-- Prescription Display -->
                <div class="form-group">
                    <label for="prescriptionOutput" style="display: block; font-weight: bold;">Prescription Details</label>
                    <div id="prescriptionOutput" style="border: 1px solid #ccc; padding: 10px; background-color: #f9f9f9;"></div>
                </div>

                <!-- Hidden fields to store modal data -->
                <input type="hidden" id="hiddenPrescription" name="prescription" />
                <input type="hidden" id="hiddenFrequency" name="frequency" />
                <input type="hidden" id="hiddenDosageTimes" name="dosage_times" />

                            <!-- Hidden fields for the take times -->
                <input type="hidden" id="hiddenTake1" name="first_take" />
                <input type="hidden" id="hiddenTake2" name="second_take" />
                <input type="hidden" id="hiddenTake3" name="third_take" />
                <input type="hidden" id="hiddenTake4" name="fourth_take" />
                <input type="hidden" id="hiddenTake5" name="fifth_take" />

            

            


            <style>
                .button-container {
    text-align: left; /* Aligns child elements to the left */
}

            </style>

<div class="button-container">
    <button type="submit" class="confirm-btn" style="background-color: #0071bc; width:100px;">Approve</button>
</div>

            </form>
                </div>
            </div>
            

            <div id="prescriptionModal" class="modal">
                <div class="modal-content">
                    <span class="close-btn" onclick="closeModal('prescriptionModal')">&times;</span>
                

                        <div class="form-group">
                            <label for="frequencySelect">Select Frequency</label>
                            <select id="frequencySelect" name="frequency">
                                <option value="1">1x a day</option>
                                <option value="2">2x a day</option>
                                <option value="3">3x a day</option>
                                <option value="4">4x a day</option>
                                <option value="5">5x a day</option>
                            </select>
                        </div>

                        <div id="timeInputsContainer"></div>

                    

                        <button type="button" id="confirmPrescriptionBtn" class="confirm-btn" style="background-color: #0071bc; width: 100px;">OK</button>
                    </form>
                </div>
            </div>

<style>
        .page-content {
            padding: 20px;
        }

        .table-container {
            display: flex;               
            justify-content: center;     
            overflow-x: auto;            
            margin: 20px auto;           
            max-width: 100%;             
        }


        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .action-btn {
            padding: 5px 10px;
            cursor: pointer;
            border: none;
            color: red;
            background-color: #4CAF50;
            border-radius: 4px;
        }

        .approve-btn {
            background-color: #0071bc;
        }
        .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 500; /* Sit on top of other elements */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: hidden; /* Disable scroll for full-screen modal */
    background-color: rgba(0, 0, 0, 0.6); /* Darker background for better contrast */
    transition: opacity 0.3s ease; /* Smooth transition effect */
}
.modal-content1 {
    background-color: #ffffff; 
    margin: 0; 
    padding: 30px;
    border: none; 
    border-radius: 0; 
    box-shadow: none; 
    width: 100%; 
    height: 50vh; 
    overflow-y: auto;
    position: absolute; 
    top: 0;
    left: 0;
}

.modal-content {
    background-color: #ffffff; /* Use a soft white for better readability */
    margin: 0; /* Remove margin for full width */
    padding: 30px;
    border: none; /* No border for a cleaner look */
    border-radius: 0; /* Remove rounded corners */
    box-shadow: none; /* Remove shadow */
    width: 100%; /* Full width */
    height: 100vh; /* Full height */
    overflow-y: auto; /* Scrollable if content is too tall */
    position: absolute; /* Positioned relative to the modal */
    top: 0;
    left: 0;
}

.close {
    color: #aaa; /* Close button color */
    float: left; /* Position it to the right */
    font-size: 28px; /* Larger font size */
    font-weight: bold; /* Bold font */
}

.close:hover,
.close:focus {
    color: #000; /* Darker color on hover/focus */
    text-decoration: none; /* Remove underline */
    cursor: pointer; /* Change cursor on hover */
}

.modal-header {
    display: flex; /* Use flexbox for layout */
    justify-content: space-between; /* Space between elements */
    align-items: center; /* Center align items */
}

.modal-body {
    margin: 10px 0; /* Space around body content */
}




.close-btn {
    color: #aaa;
    float: left;
    font-size: 28px;
    font-weight: bold;
}

.close-btn:hover,
.close-btn:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

        h2 {
            margin-top: 0;
        }

      
        .table-container {
            overflow-x: auto; 
            margin: 0 -15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            background-color: #f2f2f2;
            padding: 12px;
            text-align: left;
        }

        tbody td {
            padding: 12px;
            border: 1px solid #ddd;
        }

     
        @media screen and (max-width: 600px) {
            table {
                font-size: 14px; 
            }

            thead th {
                font-size: 12px;
            }

            tbody td {
                font-size: 12px;
            }
        }

        @media screen and (max-width: 400px) {
            table {
                font-size: 12px; 
            }
        }

      
        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid black;
            border-radius: 4px;
            box-sizing: border-box;
        }



        .confirm-btn {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        
        }

        .confirm-btn:hover {
            background-color: #45a049;
        }

        
        @media screen and (max-width: 600px) {
            .modal-content {
                width: 95%;
                margin: 10% auto;
            }

            .close-btn {
                font-size: 24px;
            }
        }

        .page-content {
            display: flex;
            justify-content: center;
            padding: 20px;
            background-color: #f0f4f8;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            width: 320px;
            padding: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            border-bottom: 2px solid #efefef;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .card-header h3 {
            font-size: 22px;
            font-weight: bold;
            margin: 0;
            color: #333;
        }

        .card-header .username {
            font-size: 14px;
            color: #777;
        }

        .card-body p, .card-health-info p {
            margin: 8px 0;
            color: #555;
        }

        .card-health-info h4 {
            font-size: 18px;
            font-weight: bold;
            margin-top: 15px;
            color: #333;
        }

        .card-footer {
            margin-top: 20px;
            text-align: center;
        }

        .action-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .action-btn:hover {
            background-color: #45a049;
        }

        
        @media (max-width: 768px) {
            .card {
                width: 100%;
            }
        }

        .action-btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 15px;
        }

        .action-btn:hover {
            background-color: #45a049;
        }
        .close-btn {
            color: red;
            float: right;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }

        .confirm-btn {
            background-color: green;
            color: white;
            padding: 10px 20px;
            cursor: pointer;
            width: 100%;
            border: none;
            font-size: 16px;
        }

        .btn {
            background-color: blue;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }

        #timeInputsContainer {
            margin-top: 10px;
        }

</style>

        
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const approvalButtons = document.querySelectorAll('.approve-btn');
        const modal = document.getElementById('approvalModal');
        const closeBtn = document.querySelector('.close-btn');
        const approveForm = document.getElementById('approveForm');
        const modalUsername = document.getElementById('modalUsername');
        const patientNameDisplay = document.getElementById('patientName');
        const symptomsInput = document.getElementById('symptomsInput');
        const predictedDiseaseInput = document.getElementById('predictedDiseaseInput');
        const predictedPrescriptionInput = document.getElementById('predictedPrescriptionInput');
        const predictedTreatmentInput = document.getElementById('predictedTreatmentInput');
        const ageDisplay = document.getElementById('age');
        const dobDisplay = document.getElementById('dob');
        const addressDisplay = document.getElementById('address');
        const weightDisplay = document.getElementById('weight');
        const heightDisplay = document.getElementById('height');
        const bloodpressureDisplay = document.getElementById('bloodpressure');
        const heartrateDisplay = document.getElementById('heartrate');

        approvalButtons.forEach(button => {
            button.addEventListener('click', function() {
                modalUsername.value = this.dataset.username;
                patientNameDisplay.textContent = this.dataset.patientName;
                symptomsInput.value = this.dataset.symptoms;
                predictedDiseaseInput.value = this.dataset.predictedDisease;
                predictedPrescriptionInput.value = this.dataset.predictedPrescription;
                predictedTreatmentInput.value = this.dataset.predictedMedicines; 
                ageDisplay.textContent = this.dataset.age;
                dobDisplay.textContent = this.dataset.dob;
                addressDisplay.textContent = this.dataset.address;
                weightDisplay.textContent = this.dataset.weight;
                heightDisplay.textContent = this.dataset.height;
                bloodpressureDisplay.textContent = this.dataset.bloodpressure;
                heartrateDisplay.textContent = this.dataset.heartrate;
                modal.style.display = 'block';
            });
        });

        closeBtn.addEventListener('click', function() {
            modal.style.display = 'none'; // Hide the modal
        });

        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none'; // Hide the modal when clicking outside
            }
        });
    });
</script>


<script>
   document.getElementById('confirmPrescriptionBtn').addEventListener('click', function () {
    const frequency = document.getElementById('frequencySelect').value;
    const dosageTimes = [];  // To store times for first_take, second_take, etc.
    

    // Loop through the time inputs based on the frequency
    for (let i = 1; i <= frequency; i++) {
        const hour = document.querySelector(`select[name="hour${i}"]`).value;
        const minute = document.querySelector(`select[name="minute${i}"]`).value;
        const ampm = document.querySelector(`select[name="am_pm${i}"]`).value;
        dosageTimes.push(`${hour}:${minute} ${ampm}`);
    }

    // Displaying the selected times on the UI
    const result = `
        <strong>Frequency:</strong> ${frequency}x a day<br>
        <strong>Dosage Times:</strong><br>
        <ul>
            ${dosageTimes.map(time => `<li>${time}</li>`).join('')}
        </ul>
        
    `;
    document.getElementById('prescriptionOutput').innerHTML = result;

    // Store the times in hidden inputs to submit to the form
    for (let i = 1; i <= 5; i++) {
        const hiddenInput = document.getElementById(`hiddenTake${i}`);
        if (i <= dosageTimes.length) {
            hiddenInput.value = dosageTimes[i - 1];  // Map first_take, second_take, etc.
        } else {
            hiddenInput.value = '';  // Clear any unused take slots
        }
    }

    closeModal('prescriptionModal');  // Close the modal after confirming
});


    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    // Open Prescription Modal
    document.getElementById('openPrescriptionModal').addEventListener('click', function() {
        document.getElementById('prescriptionModal').style.display = 'block';
    });

    // Confirm Prescription
    document.getElementById('confirmPrescriptionBtn').addEventListener('click', function() {
        const frequency = document.getElementById('frequencySelect').value;
        const times = [];

        for (let i = 1; i <= frequency; i++) {
            const hour = document.querySelector(`select[name="hour${i}"]`).value;
            const minute = document.querySelector(`select[name="minute${i}"]`).value;
            const ampm = document.querySelector(`select[name="am_pm${i}"]`).value;
            times.push(`${hour}:${minute} ${ampm}`);
        }

        const result = `
            <strong>Frequency:</strong> ${frequency}x a day<br>
            <strong>Dosage Times:</strong><br>
            <ul>
                ${times.map(time => `<li>${time}</li>`).join('')}
            </ul>
           
        `;
        
        document.getElementById('prescriptionOutput').innerHTML = result;

        // Store data in hidden inputs for form submission
        document.getElementById('hiddenFrequency').value = frequency;
        document.getElementById('hiddenDosageTimes').value = times.join(', '); // Store as comma-separated values
       
        closeModal('prescriptionModal');
    });
</script>


<script>
            document.addEventListener('DOMContentLoaded', function() {
            const openPrescriptionModalBtn = document.getElementById('openPrescriptionModal');
            const prescriptionModal = document.getElementById('prescriptionModal');
            const closePrescriptionBtn = document.querySelector('.close-btn');
            const confirmPrescriptionBtn = document.getElementById('confirmPrescriptionBtn');
            const prescriptionInput = document.getElementById('prescriptionInput');
            const frequencySelect = document.getElementById('frequencySelect');
            const timeInputsContainer = document.getElementById('timeInputsContainer');
            const prescriptionOutput = document.getElementById('prescriptionOutput');
            

            // Open the modal
            openPrescriptionModalBtn.addEventListener('click', function() {
                prescriptionModal.style.display = 'block';
            });

            // Close the modal
            closePrescriptionBtn.addEventListener('click', function() {
                prescriptionModal.style.display = 'none';
            });

            window.addEventListener('click', function(event) {
                if (event.target === prescriptionModal) {
                    prescriptionModal.style.display = 'none';
                }
            });

   

        // Update time inputs based on frequency selection
        frequencySelect.addEventListener('change', function() {
            const frequency = parseInt(frequencySelect.value);
            timeInputsContainer.innerHTML = ''; // Clear previous inputs

            for (let i = 1; i <= frequency; i++) {
                const timeGroup = document.createElement('div');
                timeGroup.className = 'time-group';

                const timeLabel = document.createElement('label');
                timeLabel.textContent = `Time for ${i} take:`;
                timeGroup.appendChild(timeLabel);

                // Hour Dropdown
                const hourSelect = document.createElement('select');
                hourSelect.name = `hour${i}`;
                for (let h = 1; h <= 12; h++) {
                    const hourOption = document.createElement('option');
                    hourOption.value = h;
                    hourOption.textContent = h;
                    hourSelect.appendChild(hourOption);
                }
                timeGroup.appendChild(hourSelect);

                // Minute Dropdown
                const minuteSelect = document.createElement('select');
                minuteSelect.name = `minute${i}`;
                [
                '00', '01', '02', '03', '04', '05', '06', '07', '08', '09',
                '10', '11', '12', '13', '14', '15', '16', '17', '18', '19',
                '20', '21', '22', '23', '24', '25', '26', '27', '28', '29',
                '30', '31', '32', '33', '34', '35', '36', '37', '38', '39',
                '40', '41', '42', '43', '44', '45', '46', '47', '48', '49',
                '50', '51', '52', '53', '54', '55', '56', '57', '58', '59'
                ]
.forEach(minute => {
                    const minuteOption = document.createElement('option');
                    minuteOption.value = minute;
                    minuteOption.textContent = minute;
                    minuteSelect.appendChild(minuteOption);
                });
                timeGroup.appendChild(minuteSelect);

                // AM/PM Dropdown
                const amPmSelect = document.createElement('select');
                amPmSelect.name = `am_pm${i}`;
                ['AM', 'PM'].forEach(ampm => {
                    const amPmOption = document.createElement('option');
                    amPmOption.value = ampm;
                    amPmOption.textContent = ampm;
                    amPmSelect.appendChild(amPmOption);
                });
                timeGroup.appendChild(amPmSelect);

                // Add the group to the container
                timeInputsContainer.appendChild(timeGroup);

                const br = document.createElement('br');
                timeInputsContainer.appendChild(br);
            }
        });

});


</script>
<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS and jQuery (required for Bootstrap modals to work) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


  

</body>
</html>