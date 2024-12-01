<?php
// Database connection parameters
$host = 'dpg-ct2lk83qf0us739u2uvg-a.oregon-postgres.render.com';
$port = '5432';  // Default PostgreSQL port
$dbname = 'opdmsis';
$user = 'opdmsis_user';
$password = '3sc6VNaexgXhje2UgoQ4fnvPf8x1KDGG';

// Create connection string
$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";

// Establish connection
$con = pg_connect($conn_string);

// Check the connection
if (!$con) {
    die("Connection failed: " . pg_last_error());
}


?>




<?php
if (isset($_GET['id'])) {
    $patientId = $_GET['id'];

    // Query the PostgreSQL database
    $query = pg_query($con, "SELECT * FROM patient_info WHERE id = $patientId");

    if (pg_num_rows($query) > 0) {
        $row = pg_fetch_assoc($query);
        echo json_encode($row); 
    } else {
        echo json_encode(['error' => 'No patient found']); 
    }
} else {
    // Handle case when 'id' is not set
}
?>
