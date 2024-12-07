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

    // Update query (use placeholders for parameters)
    $updateQuery = "UPDATE admin_log SET name = $1, date_birth = $2, admin_email = $3, mobile = $4, admin_address = $5";

    // If password is provided, include it in the update
    if (!empty($new_password)) {
        $updateQuery .= ", password = $6";
    }

    $updateQuery .= " WHERE id = $1";

    // Prepare the statement
    $stmt = pg_prepare($con, "update_admin", $updateQuery);

    // Bind parameters based on whether a new password was provided
    if (!empty($new_password)) {
        // Bind parameters (password is also passed)
        $params = [$name, $birthdate, $admin_email, $mob_num, $admin_address, $new_password, $adminId];
    } else {
        // Bind parameters without the password
        $params = [$name, $birthdate, $admin_email, $mob_num, $admin_address, $adminId];
    }

    // Execute the query
    $result = pg_execute($con, "update_admin", $params);

    if ($result) {
        echo "Admin details updated successfully.";
    } else {
        echo "Error updating admin details: " . pg_last_error($con);
    }

    // Close the connection
    pg_close($con);
}
?>
