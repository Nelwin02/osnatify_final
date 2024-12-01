
<?php
session_start(); // Start the session to access session variables

include 'db.php';

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username']; // Get the username from the session

    // Prepare and execute the SQL statement
    $sql = "SELECT predicted_prescription FROM patient_info WHERE username=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($predicted_prescription);
    $stmt->fetch();
    $stmt->close();
} else {
    // Handle the case where the user is not logged in
    echo "User not logged in.";
}
?>