<?php
// delete_patient.php
include 'db.php'; // Ensure to include your database connection script

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    // Prepare a delete statement using PostgreSQL
    $sql = "DELETE FROM patient_info WHERE id = $1"; // $1 is a placeholder for the parameter

    // Prepare and execute the statement
    $result = pg_prepare($con, "delete_patient", $sql); // Prepare the query
    $result = pg_execute($con, "delete_patient", array($id)); // Execute the query with the id parameter

    if ($result) {
        echo "Success";
    } else {
        echo "Error: " . pg_last_error($con); // Get PostgreSQL error
    }

    // Close the connection (optional with PostgreSQL, since pg_close is not strictly needed)
    pg_close($con);
}
?>
