<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

function sendNotification($recipient_email, $subject, $message_body) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = ''; // your Gmail
        $mail->Password = '';    // your App password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('', 'Law Office System'); // add your email here
        $mail->addAddress($recipient_email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message_body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}
?>
