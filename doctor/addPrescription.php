<?php
include 'db.php';
session_start();

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './phpmailer/src/Exception.php';
require './phpmailer/src/PHPMailer.php';
require './phpmailer/src/SMTP.php';

// Get the submitted data from the form
$username = $_POST['username'] ?? '';
$predicted_disease = $_POST['predicted_disease'] ?? '';
$predicted_prescription = $_POST['predicted_prescription'] ?? '';
$frequency = (int)($_POST['frequency'] ?? 0);
$duration = $_POST['duration'] ?? '';

// Collect the dosage times directly from the form
$first_take = $_POST['first_take'] ?? null;
$second_take = $_POST['second_take'] ?? null;
$third_take = $_POST['third_take'] ?? null;
$fourth_take = $_POST['fourth_take'] ?? null;
$fifth_take = $_POST['fifth_take'] ?? null;

// Function to convert 12-hour format to 24-hour format
function convertTo24Hour($time) {
    if ($time) {
        list($hour_minute, $ampm) = explode(' ', $time);
        list($hour, $minute) = explode(':', $hour_minute);
        $hour = (int)$hour;

        // Convert hour to 24-hour format
        if ($ampm === 'PM' && $hour !== 12) {
            $hour += 12;
        } elseif ($ampm === 'AM' && $hour === 12) {
            $hour = 0; // Midnight case
        }

        return sprintf('%02d:%02d:00', $hour, $minute); // Format as HH:MM:00
    }
    return null;
}

// Convert dosage times to 24-hour format
$first_take = convertTo24Hour($first_take);
$second_take = convertTo24Hour($second_take);
$third_take = convertTo24Hour($third_take);
$fourth_take = convertTo24Hour($fourth_take);
$fifth_take = convertTo24Hour($fifth_take);

// Insert a new record into the doctor_confirm table
$sql_insert = "INSERT INTO doctor_confirm (username, diagnosis, prescription, frequency, duration, first_take, second_take, third_take, fourth_take, fifth_take) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt_insert = $con->prepare($sql_insert);
$stmt_insert->bind_param("sssiisssss", $username, $predicted_disease, $predicted_prescription, $frequency, $duration, $first_take, $second_take, $third_take, $fourth_take, $fifth_take);

if ($stmt_insert->execute()) {
    $_SESSION['message'] = "Prescription submitted successfully!";

     // Update patient status to 'approved'
     $sql_update_status = "UPDATE patient_info SET status = 'approved' WHERE username = ?";
     $stmt_update_status = $con->prepare($sql_update_status);
     $stmt_update_status->bind_param("s", $username);
     $stmt_update_status->execute();
     $stmt_update_status->close();

    // Fetch email addresses from patient_info table based on the username
    $sql_email = "SELECT email FROM patient_info WHERE username = ?";
    $stmt_email = $con->prepare($sql_email);
    $stmt_email->bind_param("s", $username);
    $stmt_email->execute();
    $result = $stmt_email->get_result();

    $emailData = [];
    while ($row = $result->fetch_assoc()) {
        $emailData[] = $row['email'];
    }

    $stmt_email->close();

    // Send emails using PHPMailer
    $mail = new PHPMailer(true);

    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'osnanotify@gmail.com'; // Your email address
    $mail->Password = 'eynrorlknfmjcktr'; // Your email password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Set the from address
    $mail->setFrom('osnanotify@gmail.com', 'Ospital Ng Nasugbu');

   // Prepare the email content
$firstTake = $first_take ? date('g:i A', strtotime($first_take)) : null;
$secondTake = $second_take ? date('g:i A', strtotime($second_take)) : null;
$thirdTake = $third_take ? date('g:i A', strtotime($third_take)) : null;
$fourthTake = $fourth_take ? date('g:i A', strtotime($fourth_take)) : null;
$fifthTake = $fifth_take ? date('g:i A', strtotime($fifth_take)) : null;

// Calculate the end date based on the duration
$currentDate = new DateTime(); // Current date
$durationDays = (int)$duration; // Get the duration as an integer
$endDate = clone $currentDate; // Clone the current date to avoid modifying it
$endDate->modify("+$durationDays days"); // Add duration days

// Format the end date
$endDateFormatted = $endDate->format('F j, Y'); // Format as "Month Day, Year"

// Start building the email body
$mailBody = "Hello,\n\nHere is your prescription, Take it on time!\n\n" .
            "Prescription: $predicted_prescription\n" .
            "Frequency: {$frequency} times a day\n" .
            "Duration: {$duration} days (until $endDateFormatted)\n\n";

// Append each dosage time if it is specified
if ($firstTake) {
    $mailBody .= "First Take: $firstTake\n";
}
if ($secondTake) {
    $mailBody .= "Second Take: $secondTake\n";
}
if ($thirdTake) {
    $mailBody .= "Third Take: $thirdTake\n";
}
if ($fourthTake) {
    $mailBody .= "Fourth Take: $fourthTake\n";
}
if ($fifthTake) {
    $mailBody .= "Fifth Take: $fifthTake\n";
}

$mailBody .= "\nBest regards,\nOspital Ng Nasugbu";

// Set the email subject and body
$mail->Subject = 'Prescription Reminder';
$mail->Body = $mailBody;


    // Add recipients and send emails
    foreach ($emailData as $email) {
        $mail->addAddress($email); // Add recipient email
        try {
            $mail->send();
            $mail->clearAddresses(); // Clear addresses for the next iteration
        } catch (Exception $e) {
            error_log("Mailer Error: {$mail->ErrorInfo} for $email");
        }
    }

} else {
    $_SESSION['error'] = "Error: " . $stmt_insert->error;
}


?>
