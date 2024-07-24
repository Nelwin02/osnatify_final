<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Doctor</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">

<!-- jQuery (necessary for DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>

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
		
					
			// Fetch doctor information
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
        $image = "default.png"; // Fallback image
    }
} else {
    $name = "Unknown";
    $image = "default.png"; // Fallback image
}
?>

          
       
            

            <?php
            // Query to count patients
            $sqlPatients = "SELECT COUNT(*) as count FROM patient_info";
            $resultPatients = mysqli_query($con, $sqlPatients);
            $countPatients = mysqli_fetch_assoc($resultPatients)['count'];
            ?>
</head>
<style>
/* Style the table headers */
.table thead th {
    background-color: #f8f9fa;
    color: #495057;
    font-weight: bold;
    text-align: center;
}

/* Style the table rows */
.table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

/* Style table borders */
.table-bordered {
    border: 1px solid #dee2e6;
}

.table-bordered th, .table-bordered td {
    border: 1px solid #dee2e6;
}

/* Style the pagination controls */
.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 0.5em 1em;
    margin: 0 0.1em;
    border: 1px solid #007bff;
    border-radius: 0.25em;
    color: #007bff;
    font-size: 0.875em;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background-color: #007bff;
    color: #fff;
}
.doctor-image {
            width: 100px; /* Adjust as needed */
            height: 100px; /* Adjust as needed */
            object-fit: cover;
            border-radius: 50%;
        }
</style>

<body>
   <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
            <span><img src="img/opd.png" alt="" width="100px"></span>
        </div>
        
       
        <div class="side-content">
            <div class="profile">
            <div ><img src="../doctor/Images/<?php echo htmlspecialchars($image); ?>" alt="Doctor Image" class="profile-img bg-img"></div>
                <h4>Welcome,</h4>
                <small><?php echo htmlspecialchars($name); ?></small>
            </div>
            
            <div class="side-menu">
                <ul>
                    <li>
                       <a href="doctor_dash.php" class="active">
                            <span class="las la-home"></span>
                            <small>Dashboard</small>
                        </a>
                    </li>
                    <li>
                       <a href="manage-pres.php">
                            <span class="las la-prescription"></span>
                            <small>Prescription</small>
                        </a>
                    </li>
                    <li>
                       <a href="manage-meds.php">
                            <span class="las la-pills"></span>
                            <small>Medicines</small>
                        </a>
                    </li>
                   
                   
                    
                    <li>
                       <a href="settings.php">
                            <span class="las la-cog"></span>
                            <small>Settings</small>
                        </a>
                    </li>
                    

                </ul>
            </div>
        </div>
    </div>
    
    <div class="main-content">
        
        <header>
            <div class="header-content">
                <label for="menu-toggle">
                    <span class="las la-bars"></span>
                </label>
                
                <div class="header-menu">
                    <label for="">
                        <span class=""></span>
                    </label>
                    
                    <div class="">
                       
                        <span class="notify"></span>
                    </div>
                    
                    <div class="notify-icon">
                        <span class="las la-bell"></span>
                        <span class="notify">3</span>
                    </div>
                    
                    
                    <div class="user">
                        <a href="profile.php">
                        <div class="bg-img" style="background-image: url('../doctor/Images/<?php echo htmlspecialchars($image); ?>');" > 
 
</div>
                    </a>
                    <a href="../doctor/login.php">
                        <span class="las la-power-off"></span>
                        <span>Logout</span>
                    </a>
                    </div>
                </div>
            </div>
        </header>
        
        
        <main>
            
            <div class="page-header">
                <h1>Dashboard</h1>
                <small>Home / Dashboard</small>
            </div>
            
            <div class="page-content">
            
                <div class="analytics">

                    <div class="card">
                        <div class="card-head">
                            <h2><?php echo $countPatients; ?></h2>
                            <span class="las la-user-friends"></span>
                        </div>
                        <div class="card-progress">
                            <small>Total Patient</small>
                            <div class="card-indicator">
                                <div class="indicator one" style="width: 60%"></div>
                            </div>
                        </div>
                    </div>

                   

                </div>


                <div class="records table-responsive">

<div class="record-header">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="datatable table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Guardian</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Age</th>
                                    <th>Sex</th>
                                    <th>Civil Status</th>
                                    <th>Dob</th>
                                    <th>Weight</th>
                                    <th>Height</th>
                                    <th>Blood Pressure</th>
                                    <th>Heart Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = mysqli_query($con, "SELECT * FROM patient_info");
                                while ($row = mysqli_fetch_array($query)) {
                                    echo "<tr>
                                            <td>{$row['id']}</td>
                                            <td>{$row['name']}</td>
                                            <td>{$row['guardian']}</td>
                                            <td>{$row['address']}</td>
                                            <td>{$row['contactnum']}</td>
                                            <td>{$row['age']}</td>
                                            <td>{$row['sex']}</td>
                                            <td>{$row['civil_status']}</td>
                                            <td>{$row['dob']}</td>
                                            <td>{$row['weight']}</td>
                                            <td>{$row['height']}</td>
                                            <td>{$row['bloodpressure']}</td>
                                            <td>{$row['heartrate']}</td>
                                          </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

					
        </main>
        
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get the progress indicator element
        const progressIndicator = document.querySelector('.indicator');
        
        // Define the final width of the progress bar
        const finalWidth = '60%'; // Change this to the width you need

        // Function to animate the width
        function animateProgressBar() {
            let width = 0;
            const interval = setInterval(function() {
                if (width >= parseFloat(finalWidth)) {
                    clearInterval(interval);
                } else {
                    width += 1; // Increment the width
                    progressIndicator.style.width = width + '%';
                }
            }, 20); // Adjust the speed by changing the interval
        }

        // Start the animation
        animateProgressBar();
    });


    //Js Table view

$(document).ready(function() {
    // Initialize DataTables with Bootstrap styling and additional options
    $('.datatable').DataTable({
        "pageLength": 1, // Default number of rows per page
        "lengthMenu": [1,5, 10, 25, 50, 100], // Options for entries per page
        "searching": true, // Enable search functionality
        "pagingType": "full_numbers", // Pagination style
        "order": [[0, 'asc']], // Default sorting by ID column
        "language": {
            "search": "Search by name or ID:",
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty": "No entries available",
            "infoFiltered": "(filtered from _MAX_ total entries)"
        },
        "columnDefs": [
            { "orderable": false, "targets": [1, 2] } // Disable sorting for specific columns if needed
        ]
    });
});
</script>

</script>

</script>

</body>
</html>