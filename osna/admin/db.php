<?php

// Check if the user is logged in (i.e., check for 'username' in the session)
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database connection parameters
$DB_HOST = 'dpg-ct2lk83qf0us739u2uvg-a.oregon-postgres.render.com';
$port = '5432';  // Default PostgreSQL port
$DB_NAME = 'opdmsis';
$DB_USER = 'opdmsis_user';
$DB_PASSWORD = '3sc6VNaexgXhje2UgoQ4fnvPf8x1KDGG';

// Create connection string
$conn_string = "host=$DB_HOST port=$port dbname=$DB_NAME user=$DB_USER password=$DB_PASSWORD";

// Establish connection
$con = pg_connect($conn_string);

// Check the connection
if (!$con) {
    die("Connection failed: " . pg_last_error());
}
?>


<?php
// Ensure the user is logged in before executing the following code
if (isset($_GET['id'])) {
    // Make sure 'id' is provided in the URL
    $patientId = $_GET['id'];

    // Query the PostgreSQL database
    $query = pg_query($con, "SELECT * FROM patient_info WHERE id = $patientId");

    if (pg_num_rows($query) > 0) {
        $row = pg_fetch_assoc($query);
        echo json_encode($row); // Return the patient data as JSON
    } else {
        // If no patient is found, return an error message
        echo json_encode(['error' => 'No patient found']); 
    }
} else {
    // If 'id' is not set, return an error
    echo json_encode(['error' => 'Patient ID is required']);
}
?>
