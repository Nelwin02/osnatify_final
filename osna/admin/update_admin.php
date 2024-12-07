<?php
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

    // If password is provided, include it in the update
    if (!empty($new_password)) {
        $updateQuery .= ", password = $6";
    }

    // Add the WHERE condition for the admin ID
    $updateQuery .= " WHERE id = $7";

    // Prepare the parameters array
    $params = [$name, $birthdate, $admin_email, $mob_num, $admin_address];

    // If password is provided, add it to the parameters array
    if (!empty($new_password)) {
        $params[] = $new_password; // Add password
    }

    // Add admin ID to the parameters array
    $params[] = $adminId;

    // Prepare the statement
    $stmt = pg_prepare($con, "update_admin", $updateQuery);

    // Execute the query
    $result = pg_execute($con, "update_admin", $params);

    // Check if the update was successful
    if ($result) {
        echo "Admin details updated successfully.";
    } else {
        echo "Error updating admin details: " . pg_last_error($con);
    }

    // Close the connection
    pg_close($con);
}
?>
