<?php
    include 'db.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require './phpmailer/src/Exception.php';
    require './phpmailer/src/PHPMailer.php';
    require './phpmailer/src/SMTP.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $emailData = [];

    foreach ($_POST['email'] as $index => $email) {
        $emailData[] = [
            'email' => $email,
            'prescription' => $_POST['prescription'][$index],
            'first_take' => $_POST['first_take'][$index],
            'second_take' => $_POST['second_take'][$index],
            'third_take' => $_POST['third_take'][$index],
            'fourth_take' => $_POST['fourth_take'][$index],
            'fifth_take' => $_POST['fifth_take'][$index],
        ];
    }

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

    foreach ($emailData as $data) {
        // Add recipient
        $mail->addAddress($data['email']);
        
        // Prepare the email content
        $prescription = $data['prescription'];
        $firstTake = $data['first_take'] ? date('H:i', strtotime($data['first_take'])) : 'Not specified';
        $secondTake = $data['second_take'] ? date('H:i', strtotime($data['second_take'])) : 'Not specified';
        $thirdTake = $data['third_take'] ? date('H:i', strtotime($data['third_take'])) : 'Not specified';
        $fourthTake = $data['fourth_take'] ? date('H:i', strtotime($data['fourth_take'])) : 'Not specified';
        $fifthTake = $data['fifth_take'] ? date('H:i', strtotime($data['fifth_take'])) : 'Not specified';

        // Email subject and body
        $mail->Subject = 'Prescription Reminder';
        $mail->Body = "Hello,\n\nHere is your prescription reminder:\n\n" .
                      "Prescription: $prescription\n" .
                      "First Take: $firstTake\n" .
                      "Second Take: $secondTake\n" .
                      "Third Take: $thirdTake\n" .
                      "Fourth Take: $fourthTake\n" .
                      "Fifth Take: $fifthTake\n\n" .
                      "Best regards,\nOspital Ng Nasugbu";

        // Send email
        try {
            $mail->send();
            $mail->clearAddresses(); // Clear addresses for the next iteration
        } catch (Exception $e) {
            error_log("Mailer Error: {$mail->ErrorInfo} for $data[email]");
        }
    }

    // Provide immediate feedback to the user
    echo "All emails have been sent successfully.";

    // Close the database connection if necessary
    $con->close();
}
?>
