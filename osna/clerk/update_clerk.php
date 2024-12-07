<?php
include 'db.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get values from the form
    $username = $_POST['username']; // Username from the form
    $new_password = $_POST['password']; // New password input
    $name = $_POST['clerk_name']; // Clerk name
    $image = $_FILES['clerk_image']['name']; // Image file name
    $clerkId = $_POST['clerk_id']; // Clerk ID (assuming you are passing this)

    // Handle image upload
    $imagePath = null;
    if (!empty($image)) {
        $imageTmpName = $_FILES['clerk_image']['tmp_name'];
        $imagePath = 'Images/' . basename($image); // Path where the image will be stored

        // Move the uploaded image to the "Images" directory
        if (!move_uploaded_file($imageTmpName, $imagePath)) {
            echo "Error uploading image.";
            exit;
        }
    }

    // Prepare the base update query and parameters
    $updateQuery = "UPDATE clerk_log SET username = $1, clerk_name = $2";
    $params = [$username, $name];

    // Add the password if provided
    if (!empty($new_password)) {
        $updateQuery .= ", password = $3";
        $params[] = $new_password; // Directly use the raw password
    }

    // Add the image if provided
    if ($imagePath !== null) {
        $updateQuery .= ", clerk_image = $4";
        $params[] = $image;
    }

    // Add the WHERE clause for the clerk ID
    $updateQuery .= " WHERE id = $5";
    $params[] = $clerkId;

    // Execute the query
    $result = pg_query_params($con, $updateQuery, $params);

    // Check if the query was successful
    if ($result) {
        // Redirect to profile.php after successful update
        header("Location: profile.php?status=success");
        exit(); // Ensure script execution stops after redirect
    } else {
        echo "Error updating clerk details: " . pg_last_error($con); // Show error if any
    }
}

// Close the PostgreSQL connection
pg_close($con);
?>
