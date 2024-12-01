<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Manage Medicines</title>
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">



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

       ?>
<?php


// Your existing code to fetch and display other content


?>



        





   
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
     <input type="checkbox" id="menu-toggle">
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
                            <span class="las la-home"></span>
                            <small>Dashboard</small>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="manage_patient.php" class="nav-link">
                            <span class="las la-prescription"></span>
                            <small>Manage Patient</small>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="old_patient.php" class="nav-link">
                            <span class="las la-approve"></span>
                            <small>Approved</small>
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
            <?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "opdmsis";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to join doctor_confirm and patient_info, fetching prescription details and email addresses
$sql = "
    SELECT dc.*, pi.email
    FROM doctor_confirm dc
    JOIN patient_info pi ON dc.username = pi.username
    ORDER BY dc.username
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Reminders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            color: white;
            background-color: #4CAF50;
            border: none;
            cursor: pointer;
            text-align: center;
        }
        .button:hover {
            background-color: #45a049;
        }
        .reminder-container {
            margin: 20px auto;
            text-align: center;
        }
    </style>
</head>
<body>

<h1>Prescription Reminder System</h1>

<form method="post" action="send_email.php"> <!-- Update form action to send_email.php -->
    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Prescription</th>
                <th>First Take</th>
                <th>Second Take</th>
                <th>Third Take</th>
                <th>Fourth Take</th>
                <th>Fifth Take</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['prescription']; ?></td>
                    <td><?php echo $row['first_take'] ? date('H:i', strtotime($row['first_take'])) : '-'; ?></td>
                    <td><?php echo $row['second_take'] ? date('H:i', strtotime($row['second_take'])) : '-'; ?></td>
                    <td><?php echo $row['third_take'] ? date('H:i', strtotime($row['third_take'])) : '-'; ?></td>
                    <td><?php echo $row['fourth_take'] ? date('H:i', strtotime($row['fourth_take'])) : '-'; ?></td>
                    <td><?php echo $row['fifth_take'] ? date('H:i', strtotime($row['fifth_take'])) : '-'; ?></td>
                </tr>
                <!-- Hidden input fields to pass all data for reminders -->
                <input type="hidden" name="email[]" value="<?php echo $row['email']; ?>">
                <input type="hidden" name="prescription[]" value="<?php echo $row['prescription']; ?>">
                <input type="hidden" name="first_take[]" value="<?php echo $row['first_take']; ?>">
                <input type="hidden" name="second_take[]" value="<?php echo $row['second_take']; ?>">
                <input type="hidden" name="third_take[]" value="<?php echo $row['third_take']; ?>">
                <input type="hidden" name="fourth_take[]" value="<?php echo $row['fourth_take']; ?>">
                <input type="hidden" name="fifth_take[]" value="<?php echo $row['fifth_take']; ?>">
            <?php endwhile; ?>
        </tbody>
    </table>
    
    <div class="reminder-container">
        <button class="button" type="submit">Remind based on time per take!</button>
    </div>
</form>

<?php
// Close the database connection
$conn->close();
?>







</body>
</html>









       



<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS and jQuery (required for Bootstrap modals to work) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


  

</body>
</html>