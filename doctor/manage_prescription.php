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
        
        <div class="table-responsive">
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
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
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
                    echo '<tr><td colspan="6" class="text-center">Error fetching data: ' . mysqli_error($con) . '</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
