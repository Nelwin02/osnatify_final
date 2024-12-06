<?php
session_start();
include '../db.php'; // Database connection file

// Check if clerk is logged in by verifying the session variable
if (!isset($_SESSION['clerk_username'])) { 
    header("Location: /osna/doctor2/login.php");
    exit();
}

// Retrieve the clerk's username from session
$clerk_username = $_SESSION['clerk_username']; 

// Fetch clerk information using prepared statements
$query = "SELECT clerk_name, clerk_image FROM clerk_log WHERE username = $1"; 
$stmt = pg_prepare($con, "fetch_clerk_info", $query);
$stmt = pg_execute($con, "fetch_clerk_info", array($clerk_username));

if ($stmt) {
    $clerk = pg_fetch_assoc($stmt);
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
<!DOCTYPE html>
<html lang="en">
    
<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:20 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Predict Sickness</title>
		
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
	<style>
	
    
	</style>
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
                                <li class="breadcrumb-item active">Predict Diagnosis, Prescription, Treatment</li>
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
					
              
              <?php
                    if (isset($_GET['username'])) {
                        $username = $_GET['username'];
                      
                        // Continue with your logic here
                    }

function predictDiseaseFromAPI($symptoms) {
    // Fetch API key from the environment variable
    $apiKey = getenv('API_KEY');

    // Check if the API key is available
    if (!$apiKey) {
        return "Error: API key is not set.";
    }

    $url = 'https://api.openai.com/v1/chat/completions';
    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey
    ];

    $question = "Based on the symptoms: using comma provide 3 common 'Diagnosis', 'Prescription', 'Treatment': " . $symptoms;

    $data = [
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            [
                'role' => 'user',
                'content' => $question
            ]
        ],
        'max_tokens' => 150,
        'temperature' => 0.5
    ];
    // Initialize cURL session
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute cURL session
    $response = curl_exec($ch);
    curl_close($ch);

    // Log the full API response for debugging
    if ($response === false) {
        return "Error: Unable to contact API.";
    }

    $result = json_decode($response, true);
    
    // Check for possible errors in the API response
    if (isset($result['error'])) {
        return "Error: " . $result['error']['message'];
    }

    // Return the content of the response
    if (isset($result['choices'][0]['message']['content'])) {
        return trim($result['choices'][0]['message']['content']);

        
    } else {
        return "Error: Unexpected API response.";
    }
}




// Function to insert the prediction data into the database and update the status
function insertPredictionIntoDB($username, $symptoms, $disease, $prescription, $treatment) {
    include 'db.php'; // Assuming db.php connects to PostgreSQL

    // Begin transaction
    pg_query($con, "BEGIN");

    try {
        // Insert the prediction data
        $sql = "INSERT INTO prediction (username, symptoms, predicted_disease, predicted_prescription, predicted_treatment) VALUES ($1, $2, $3, $4, $5)";
        $result = pg_prepare($con, "insert_prediction", $sql);
        $result = pg_execute($con, "insert_prediction", array($username, $symptoms, $disease, $prescription, $treatment));

        if (!$result) {
            throw new Exception("Error inserting prediction data: " . pg_last_error($con));
        }

        // Update the status in vitalsigns to 'done'
        $updateSql = "UPDATE vitalsigns SET status = 'done' WHERE username = $1";
        $updateResult = pg_prepare($con, "update_status", $updateSql);
        $updateResult = pg_execute($con, "update_status", array($username));

        if (!$updateResult) {
            throw new Exception("Error updating status: " . pg_last_error($con));
        }

        // Commit the transaction
        pg_query($con, "COMMIT");

        // Success: Show the modal and redirect after OK
        echo '
        <div id="successModal" class="modal">
            <div class="modal-content">
                <p>Prediction saved, Ready for Prescription!.</p>
                <button id="okButton">OK</button>
            </div>
        </div>
        <script>
            var modal = document.getElementById("successModal");
            modal.style.display = "block";
            document.getElementById("okButton").onclick = function() {
                modal.style.display = "none";
                // Redirect to consult_patient.php with the same username
                window.location.href = "consult_patient.php?username=' . urlencode($username) . '";
            };
        </script>
        ';

    } catch (Exception $e) {
        // Rollback the transaction on error
        pg_query($con, "ROLLBACK");
        echo "Transaction failed: " . $e->getMessage();
    }

    // Close the database connection
    pg_close($con);
}
?>
<?php
// Assume you have a database connection set up as $con
$username = $_GET['username']; // Retrieve the username from the URL or session

// Initialize the patientName variable
$patientName = "";

// Prepare the query to get the patient's name
$query = "SELECT name FROM patient_info WHERE username = $1";

// Prepare the query
$stmt = pg_prepare($con, "get_patient_name", $query);

// Execute the query
$result = pg_execute($con, "get_patient_name", array($username));

// Check if the query was successful and fetch the result
if ($result) {
    $row = pg_fetch_assoc($result);
    if ($row) {
        $patientName = $row['name']; // Assign the patient's name to the variable
    } else {
        // If no result, you can set a default value or handle it
        $patientName = "Not Found"; 
    }
} else {
    // Handle query failure
    echo "Error executing query: " . pg_last_error($con);
}

// Close the result set and connection
pg_free_result($result);
pg_close($con);
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prediction</title>
    <style>
           
       
        .container {
            width: 60%;
            max-width: 600px; 
            margin: 2rem auto; 
            padding: 20px;
            background-color: #ffffff; 
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center; 
            color: #007bff; 
            font-size: 28px;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block; 
        }

        textarea, select, input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ced4da; 
            border-radius: 8px; 
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        textarea:focus, select:focus, input[type="submit"]:focus {
            border-color: #007bff; 
            outline: none; 
        }

        input[type="submit"] {
            background-color: #007bff; 
            color: white;
            cursor: pointer;
            font-weight: bold;
            border: none; 
        }

        input[type="submit"]:hover {
            background-color: #0056b3; 
        }

        .result {
            margin-top: 20px;
            background-color: #d1ecf1; 
            color: #0c5460; 
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #bee5eb; 
            display: none; /* Initially hidden */
        }
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

        .prediction-history {
            width: 35%; 
            max-width: 300px; 
            float: right; 
            background-color: #f8f9fa; 
            border-radius: 8px;
            padding: 15px;
            margin-left: 20px; 
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .prediction-history h3 {
            text-align: center;
            color: #007bff; 
        }

        .prediction-history ul {
            list-style-type: none; 
            padding: 0; 
            max-height: 150px; 
            overflow-y: auto; 
        }

        .prediction-history li {
            margin-bottom: 15px; 
            border-bottom: 1px solid #ced4da;
            padding-bottom: 10px;
        }

        .view-all {
            text-align: center; 
            margin-top: 10px;
        }

        .view-all button {
            background-color: #007bff; 
            color: white;
            border: none;
            border-radius: 5px; 
            padding: 10px 15px;
            cursor: pointer;
            font-weight: bold;
        }

        .view-all button:hover {
            background-color: #0056b3; 
        }
        /* Style for the container */


/* Style for the input field */
input[type="text"] {
  padding: 8px 12px;
  font-size: 16px;
  border-radius: 8px;
  border: 1px solid #ccc;
  width: 250px;
  background-color: #f9f9f9;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

/* Style for the button */
.toggle-button {
  padding: 8px 10px;
  font-size: 16px;
  background-color: #024CAA;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Hover effect for the button */
.toggle-button:hover {
  background-color: #024CAA;
  transform: translateY(-2px);
}

/* Focus effect for input field */
input[type="text"]:focus {
  outline: none;
  border-color: #4CAF50;
  box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
}

/* Transition for button text change */
.toggle-button:focus {
  outline: none;
}

    </style>
    
</head>
<body>
    <div class="container">
        <h1 style="font-size: 25px; font-weight: bold;">How are you feeling right now?</h1>
        <style>
    input[type="text"] {
        width: 100%;
        padding: 10px;
        margin: 8px 0;
        box-sizing: border-box;
        border: 2px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        transition: border-color 0.3s ease;
    }

    input[type="text"]:focus {
        border-color: #007BFF; /* Blue border on focus */
        outline: none; /* Remove default outline */
    }
</style>
<input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" hidden/>
<!-- Input field for name with a button inside to show/hide username -->
<div>
  <input type="text" name="name" value="<?php echo htmlspecialchars($patientName); ?>" readonly />
  
  <!-- Button to show/hide username -->
  <button type="button" onclick="toggleUsername()" class="toggle-button">Show P_ID</button>

  <!-- Hidden input field containing the username -->
  <input type="hidden" id="username" value="<?php echo htmlspecialchars($username); ?>" />
</div>

<script>
  function toggleUsername() {
    // Get the button and the username input
    var button = event.target;
    var username = document.getElementById('username').value;

    // Check if the username is currently visible
    var nameInput = document.querySelector('input[name="name"]');
    
    if (nameInput.value === "<?php echo htmlspecialchars($patientName); ?>") {
      // If the name is showing, show the username and change the button text
      nameInput.value = username;
      button.innerHTML = 'Show Name';
    } else {
      // If the username is showing, show the patient name and change the button text
      nameInput.value = "<?php echo htmlspecialchars($patientName); ?>";
      button.innerHTML = 'Show P_ID';
    }
  }
</script>


        <form method="POST">
            <input type="hidden" name="username" value="<?php echo $username; ?>" />
            <label for="symptoms"></label>
            <textarea name="symptoms" id="symptoms" rows="4" placeholder="Enter your symptoms" required></textarea>
            <input type="submit" value="Predict">
        </form>

        <div class="result" id="predictionResult">
            <h3 style='font-weight: bold'>Prediction Results:</h3>
            <p id="predictionDetails"></p>
        </div>

        <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $symptoms = $_POST['symptoms'];
    $username = $_POST['username']; // Get the username from the form
    $predictedData = predictDiseaseFromAPI($symptoms);

    // Initialize variables for disease, prescription, and treatment
    $disease = 'N/A';
    $prescription = 'N/A';
    $treatment = 'N/A';

    // Split the API response into lines
    $predictedEntries = explode("\n", $predictedData);
    $resultDetails = '';

    // Loop through the predicted entries and identify relevant sections
    foreach ($predictedEntries as $entry) {
        $entry = trim($entry);
        if (strpos(strtolower($entry), 'diagnosis') !== false) {
            $disease = $entry;
        } elseif (strpos(strtolower($entry), 'prescription') !== false || strpos(strtolower($entry), 'medication') !== false) {
            $prescription = $entry;
        } elseif (strpos(strtolower($entry), 'treatment') !== false) {
            $treatment = $entry;
        }
        $resultDetails .= htmlspecialchars($entry) . '<br>';
    }

    // If no prescription was explicitly found, set it as "Not provided"
    if ($prescription === 'N/A') {
        $prescription = 'Not provided';
    }

    // Insert the prediction data into the PostgreSQL database
    insertPredictionIntoDB($username, $symptoms, $disease, $prescription, $treatment);

    // Display prediction results in the HTML
    echo "<script>
        document.getElementById('predictionResult').style.display = 'block';
        document.getElementById('predictionDetails').innerHTML = '{$resultDetails}';
    </script>";
}
        ?>
    </div>
</body>
</html>



    










			
		
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

	
    </body>

<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:34 GMT -->
</html>
