<?php
// Include database connection
include 'db.php'; // Assuming you have a file for your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $predicted_prescription = $_POST['predicted_prescription'];
    $patient_id = $_POST['patient_id']; // Assuming patient_id is passed in the request

    // Ensure both prescription and patient ID exist
    if (!empty($predicted_prescription) && !empty($patient_id)) {
        // Update the prescription in the patient_info table
        $sql = "UPDATE patient_info SET predicted_prescription = ? WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $predicted_prescription, $patient_id); // Bind the prescription and patient ID

        // Execute the query and check if it was successful
        if ($stmt->execute()) {
            echo json_encode(["success" => true]); // Successfully updated
        } else {
            echo json_encode(["success" => false, "error" => $con->error]); // Error during execution
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "error" => "Invalid input data."]); // Handle missing input
    }

    $con->close(); // Close the database connection
}
?>
