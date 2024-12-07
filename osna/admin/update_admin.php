<?php
ob_start(); // Start output buffering

include 'db.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adminId = $_POST['admin_id'];
    $name = $_POST['name'];
    $birthdate = $_POST['date_birth'];
    $admin_email = $_POST['admin_email'];
    $mob_num = $_POST['mobile'];
    $admin_address = $_POST['admin_address'];
    $new_password = $_POST['new_password'];

    // Base update query (use placeholders for parameters)
    $updateQuery = "UPDATE admin_log SET name = $1, date_birth = $2, admin_email = $3, mobile = $4, admin_address = $5";

    // Prepare the parameters array
    $params = [$name, $birthdate, $admin_email, $mob_num, $admin_address];

    // If a new password is provided, include it in the update
    if (!empty($new_password)) {
        $updateQuery .= ", password = $6"; // Add password to the query
        $params[] = $new_password; // Add password to the params array
    } else {
        // If password is empty or not provided, include NULL in the update
        $updateQuery .= ", password = NULL"; // Set password to NULL if no new password is provided
    }

    // Add the WHERE condition for the admin ID
    $updateQuery .= " WHERE id = $7";
    $params[] = $adminId; // Add admin ID to the parameters array

    // Prepare the statement
    $stmt = pg_prepare($con, "update_admin", $updateQuery);

    // Check if the prepare was successful
    if (!$stmt) {
        echo "Error preparing query: " . pg_last_error($con);
        exit; // Exit if the prepare fails
    }

    // Execute the query
    $result = pg_execute($con, "update_admin", $params);

    // Check if the update was successful
    if ($result) {
        // Redirect to profile.php with a success message
        header("Location: profile.php?status=success");
        exit;
    } else {
        // Redirect to profile.php with an error message
        header("Location: profile.php?status=error");
        exit;
    }

    // Close the connection
    pg_close($con);
}

ob_end_flush(); // End output buffering and flush output
?>
