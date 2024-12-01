<?php
include 'db.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get values from the form
    $username = $_POST['username']; // Username from the form
    $new_password = $_POST['password']; // New password input (optional)
    $doctor_name = $_POST['doctor_name']; // Doctor's name
    $image = $_FILES['doctor_image']['name']; // Image file name
    $doctorId = $_POST['doctor_id']; // Doctor ID (from hidden input)

    // If a password is provided, hash it
    if (!empty($new_password)) {
        $new_password = password_hash($new_password, PASSWORD_DEFAULT); // Hash the password
    }

    // Handle image upload
    if (!empty($image)) {
        $imageTmpName = $_FILES['doctor_image']['tmp_name'];
        $imagePath = 'Images/' . basename($image); // Path where the image will be stored

        // Validate file type and size (optional: limit file size to 2MB for example)
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
        $file_type = $_FILES['doctor_image']['type'];
        $file_size = $_FILES['doctor_image']['size'];

        if (!in_array($file_type, $allowed_types)) {
            echo "Invalid file type.";
            exit;
        }

        // Validate file size (max 2MB)
        if ($file_size > 2 * 1024 * 1024) {
            echo "File size exceeds limit of 2MB.";
            exit;
        }

        // Sanitize filename to avoid issues with special characters
        $sanitized_image = uniqid() . '_' . basename($image);

        // Move the uploaded image to the "Images" directory
        if (!move_uploaded_file($imageTmpName, 'Images/' . $sanitized_image)) {
            echo "Error uploading image.";
            exit;
        }
        $image = $sanitized_image;
    } else {
        $image = ''; // If no image is uploaded, don't update the image field
    }

    // Prepare the base update query
    $updateQuery = "UPDATE doctor_log SET 
                        username = $1, 
                        doctor_name = $2, 
                        doctor_image = $3 WHERE id = $4";

    // If a new password is provided, include it in the update query
    if (!empty($new_password)) {
        $updateQuery = "UPDATE doctor_log SET 
                        username = $1, 
                        password = $2, 
                        doctor_name = $3, 
                        doctor_image = $4 WHERE id = $5";
    }

    // Prepare and execute the statement
    $stmt = pg_prepare($con, "update_doctor", $updateQuery);

    // Bind parameters based on whether the password is included
    if (!empty($new_password)) {
        // Bind parameters including the new password
        $result = pg_execute($con, "update_doctor", array($username, $new_password, $doctor_name, $image, $doctorId));
    } else {
        // Bind parameters without the password
        $result = pg_execute($con, "update_doctor", array($username, $doctor_name, $image, $doctorId));
    }

    // Execute the query
    if ($result) {
        // Redirect to profile.php after successful update
        header("Location: profile.php");
        exit(); // Ensure script execution stops after redirect
    } else {
        echo "Error updating doctor details: " . pg_last_error($con); // Show error if any
    }

    // Close the connection (PostgreSQL does not require statement close)
    pg_close($con);
}
?>
