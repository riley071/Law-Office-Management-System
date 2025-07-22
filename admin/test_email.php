<?php
include 'send_email.php';

$to = "matewereimmanuel@gmail.com"; // replace with actual recipient
$subject = "Case Reminder";
$body = "
    <h3>Reminder: Court Date Approaching</h3>
    <p>This is a reminder that your upcoming court session is scheduled within the next 30 minutes. Please be prepared.</p>
";

if (sendNotification($to, $subject, $body)) {
    echo "Email sent successfully!";
} else {
    echo "Email failed!";
}
?>
