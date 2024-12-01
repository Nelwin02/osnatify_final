<?php
// delete_patient.php
include 'db.php'; // Ensure to include your database connection script

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    // Prepare a delete statement
    $query = "DELETE FROM patient_info WHERE id = $1";
    $result = pg_query_params($con, $query, array($id));

    if ($result) {
        echo "Success";
    } else {
        echo "Error: " . pg_last_error($con);
    }

    pg_close($con);
}
?>
