<?php
include 'db.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get values from the form
    $username = $_POST['username']; // Username from the form
    $new_password = $_POST['password']; // New password input
    $name = $_POST['clerk_name']; // Clerk name
    $image = $_FILES['clerk_image']['name']; // Image file name
    $clerkId = $_POST['clerk_id']; // Clerk ID (assuming you are passing this)

    // If a password is provided, hash it
    if (!empty($new_password)) {
        $new_password = password_hash($new_password, PASSWORD_DEFAULT); // Hash the password
    }

    // Handle image upload
    if (!empty($image)) {
        $imageTmpName = $_FILES['clerk_image']['tmp_name'];
        $imagePath = 'Images/' . basename($image); // Path where the image will be stored

        // Move the uploaded image to the "Images" directory
        if (!move_uploaded_file($imageTmpName, $imagePath)) {
            echo "Error uploading image.";
            exit;
        }
    }

    // Prepare the base update query
    $updateQuery = "UPDATE clerk_log SET 
                        username = $1, 
                        clerk_name = $2, 
                        clerk_image = $3 WHERE id = $4"; // Assuming you use 'id' to identify the clerk

    // If a new password is provided, include it in the update query
    if (!empty($new_password)) {
        $updateQuery = "UPDATE clerk_log SET 
                        username = $1, 
                        password = $2, 
                        clerk_name = $3,
                        clerk_image = $4 WHERE id = $5";
    }

    // Prepare the query using pg_query_params (PostgreSQL query execution with parameterized queries)
    if (!empty($new_password)) {
        // Bind parameters including the new password
        $result = pg_query_params($con, $updateQuery, array($username, $new_password, $name, $image, $clerkId));
    } else {
        // Bind parameters without the password
        $result = pg_query_params($con, $updateQuery, array($username, $name, $image, $clerkId));
    }

    // Check if the query was successful
    if ($result) {
        // Redirect to profile.php after successful update
        header("Location: profile.php");
        exit(); // Ensure script execution stops after redirect
    } else {
        echo "Error updating clerk details: " . pg_last_error($con); // Show error if any
    }
}
pg_close($con); // Close the PostgreSQL connection
?>
