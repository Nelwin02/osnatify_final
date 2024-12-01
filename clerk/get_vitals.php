<?php
include 'db.php';
// Retrieve username from query string
$username = $_GET['username'];

// SQL query to select all vitals data for the specific username
$sql = "SELECT weight, height, bloodpressure, heartrate, date_added FROM vitalsigns WHERE username = $1";

// Prepare the query
$stmt = pg_prepare($con, "get_vitals", $sql);

// Execute the query with the provided username
$result = pg_execute($con, "get_vitals", array($username));

$vitals = [];

// Fetch all rows and store in the $vitals array
while ($row = pg_fetch_assoc($result)) {
    $vitals[] = $row;
}

// Return the data as JSON
echo json_encode($vitals);

// Close connection
pg_close($con);
?>
