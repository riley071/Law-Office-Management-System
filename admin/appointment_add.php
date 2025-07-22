<?php
include 'includes/connection.php';

// PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $client_id = $_POST['client_id'];
   $attorney_id = $_POST['attorney_id'];
   $service_id = $_POST['service_id'];
   $appointment_date = $_POST['appointment_date']; 
   $remarks = $_POST['remarks'];
   $status = $_POST['status'];
   $reference_number = "REF-" . rand(1000, 9999) . "-21";

   // Insert the appointment into tbl_appointment
   $query = "INSERT INTO tbl_appoinment (client_id, attorney_id, service_id, appointment_date, remarks, status, reference_number) 
             VALUES ('$client_id', '$attorney_id', '$service_id', '$appointment_date', '$remarks', '$status', '$reference_number')";
   
   if (mysqli_query($conn, $query)) {
      $appointment_id = mysqli_insert_id($conn);  // Get the last inserted appointment ID

      // Fetch client and attorney email addresses
      $client_query = mysqli_query($conn, "SELECT email_address FROM tbl_client WHERE client_id = '$client_id'");
      $attorney_query = mysqli_query($conn, "SELECT attorney_email FROM tbl_attorney WHERE attorney_id = '$attorney_id'");

      $client_email = mysqli_fetch_assoc($client_query)['email_address'];
      $attorney_email = mysqli_fetch_assoc($attorney_query)['attorney_email'];

      // Insert notification for client
      // Insert notification for client
$client_message = "Dear Client,\n\nYour appointment has been scheduled successfully with Ref #: $reference_number on $appointment_date.\n\nRegards,\nLaw Office";
$client_subject = "New Appointment Confirmation";
$insert_notification_client = "INSERT INTO tbl_notifications (recipient_email, subject, message, appointment_id, status) 
                               VALUES ('$client_email', '$client_subject', '$client_message', '$appointment_id', 'pending')";
mysqli_query($conn, $insert_notification_client);

      // Insert notification for attorney
      $attorney_message = "Dear Attorney,\n\nYou have a new appointment assigned with Ref #: $reference_number on $appointment_date.\n\nPlease check your portal for details.";
      $attorney_subject = "New Appointment Assigned";
      $insert_notification_attorney = "INSERT INTO tbl_notifications (recipient_email, subject, message, appointment_id, status) 
                                       VALUES ('$attorney_email', '$attorney_subject', '$attorney_message', '$appointment_id', 'pending')";
      mysqli_query($conn, $insert_notification_attorney);

      // Optionally, you can send the email notifications right away
      // Here’s how we send the email:

      $mail = new PHPMailer(true);

      try {
          $mail->isSMTP();
          $mail->Host       = 'smtp.gmail.com';  // or your mail server
          $mail->SMTPAuth   = true;
          $mail->Username = 'emzomatewere@gmail.com'; // your Gmail
          $mail->Password = 'zkpi hcgp wfjo mobh';    // your App password
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
          $mail->Port       = 587;

          // Send to client
          $mail->setFrom('your-email@gmail.com', 'Law Office');
          $mail->addAddress($client_email);
          $mail->Subject = $client_subject;
          $mail->Body    = $client_message;
          $mail->send();

          // Clear recipients and send to attorney
          $mail->clearAddresses();
          $mail->addAddress($attorney_email);
          $mail->Subject = $attorney_subject;
          $mail->Body    = $attorney_message;
          $mail->send();

          echo "<script>alert('Appointment added and notifications sent successfully!'); window.location.href='appointment.php';</script>";
      } catch (Exception $e) {
          echo "<script>alert('Error sending email notifications.');</script>";
      }

   } else {
      echo "<script>alert('Error adding appointment.');</script>";
   }
}
?>


<!DOCTYPE html>
<html lang="en">
<?php include 'includes/header.php'?>
<body>
<div class="wrapper">
   <?php include 'includes/topbar.php'?>
   <?php include 'includes/sidebar.php'?>

   <div class="content-wrapper">
      <section class="content">
         <div class="container-fluid">
            <div class="card card-info">
               <div class="card-header">
                  <h3>Add New Appointment</h3>
               </div>
               <div class="card-body">
                  <form method="POST">
                     <!-- Client -->
                     <div class="form-group">
                        <label for="client_id">Client</label>
                        <select name="client_id" class="form-control" required>
                           <option value="">Select Client</option>
                           <?php
                           $client_result = mysqli_query($conn, "SELECT * FROM tbl_client");
                           while ($client = mysqli_fetch_assoc($client_result)) {
                              echo "<option value='{$client['client_id']}'>{$client['client_firstname']} {$client['client_lastname']}</option>";
                           }
                           ?>
                        </select>
                     </div>

                     <!-- Attorney -->
                     <div class="form-group">
                        <label for="attorney_id">Attorney</label>
                        <select name="attorney_id" class="form-control" required>
                           <option value="">Select Attorney</option>
                           <?php
                           $attorney_result = mysqli_query($conn, "SELECT * FROM tbl_attorney");
                           while ($attorney = mysqli_fetch_assoc($attorney_result)) {
                              echo "<option value='{$attorney['attorney_id']}'>{$attorney['first_name']} {$attorney['last_name']}</option>";
                           }
                           ?>
                        </select>
                     </div>

                     <!-- Service -->
                     <div class="form-group">
                        <label for="service_id">Service</label>
                        <select name="service_id" class="form-control" required>
                           <option value="">Select Service</option>
                           <?php
                           $service_result = mysqli_query($conn, "SELECT * FROM tbl_firm_services");
                           while ($service = mysqli_fetch_assoc($service_result)) {
                              echo "<option value='{$service['service_id']}'>{$service['service_name']}</option>";
                           }
                           ?>
                        </select>
                     </div>

                     <!-- ✅ Appointment Date -->
                     <div class="form-group">
                        <label for="appointment_date">Appointment Date & Time</label>
                        <input type="datetime-local" name="appointment_date" class="form-control" required>
                     </div>

                     <!-- Remarks -->
                     <div class="form-group">
                        <label for="remarks">Remarks</label>
                        <textarea name="remarks" class="form-control" rows="4" required></textarea>
                     </div>

                     <!-- Status -->
                     <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" class="form-control" required>
                           <option value="0">Pending</option>
                           <option value="1">Completed</option>
                           <option value="2">Cancelled</option>
                        </select>
                     </div>

                     <button type="submit" class="btn btn-primary">Save Appointment</button>
                  </form>
               </div>
            </div>
         </div>
      </section>
   </div>
</div>
</body>
</html>
