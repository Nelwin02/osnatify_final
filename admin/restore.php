<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    // Prepare an update statement to restore the record
    $stmt = $con->prepare("UPDATE patient_info SET is_archived = FALSE WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "RestoreSuccess";
    } else {
        echo "RestoreError: " . $stmt->error;
    }

    $stmt->close();
    $con->close();
}
?>
