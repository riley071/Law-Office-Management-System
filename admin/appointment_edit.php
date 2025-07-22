<!-- appointment_edit.php -->

<?php
include 'includes/connection.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

$appointment_id = $_GET['id'];
$query = "SELECT * FROM tbl_appoinment WHERE appointment_id = '$appointment_id'";
$result = mysqli_query($conn, $query);
$appointment = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $client_id = $_POST['client_id'];
    $attorney_id = $_POST['attorney_id'];
    $service_id = $_POST['service_id'];
    $remarks = $_POST['remarks'];
    $status = $_POST['status'];

    $update_query = "UPDATE tbl_appoinment SET client_id = '$client_id', attorney_id = '$attorney_id', service_id = '$service_id', remarks = '$remarks', status = '$status' WHERE appointment_id = '$appointment_id'";

    if (mysqli_query($conn, $update_query)) {
        // Fetch emails
        $client_q = mysqli_query($conn, "SELECT * FROM tbl_client WHERE client_id = '$client_id'");
        $client = mysqli_fetch_assoc($client_q);
        $client_email = $client['email'];
        $client_name = $client['client_firstname'] . ' ' . $client['client_lastname'];

        $attorney_q = mysqli_query($conn, "SELECT * FROM tbl_attorney WHERE attorney_id = '$attorney_id'");
        $attorney = mysqli_fetch_assoc($attorney_q);
        $attorney_email = $attorney['email'];
        $attorney_name = $attorney['first_name'] . ' ' . $attorney['last_name'];

        $status_text = match ($status) {
            "0" => "Pending",
            "1" => "Completed",
            "2" => "Cancelled",
            default => "Unknown",
        };

        $message = "Dear %s,<br><br>Your appointment has been updated.<br><strong>Status:</strong> %s<br><strong>Remarks:</strong> %s<br><br>Thank you,<br>Law Office Team";

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'emzomatewere@gmail.com';
            $mail->Password   = 'zkpi hcgp wfjo mobh'; // Gmail app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('emzomatewere@gmail.com', 'Law Office System');
            $mail->isHTML(true);
            $mail->Subject = 'Appointment Updated';

            // Email to client
            $mail->clearAddresses();
            $mail->addAddress($client_email, $client_name);
            $mail->Body = sprintf($message, $client_name, $status_text, $remarks);
            $mail->send();

            // Email to attorney
            $mail->clearAddresses();
            $mail->addAddress($attorney_email, $attorney_name);
            $mail->Body = sprintf($message, $attorney_name, $status_text, $remarks);
            $mail->send();

        } catch (Exception $e) {
            error_log("Notification email failed: " . $mail->ErrorInfo);
        }

        echo "<script>alert('Appointment updated and notifications sent!'); window.location.href='appointment.php';</script>";
    } else {
        echo "<script>alert('Error updating appointment.');</script>";
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
                            <h3>Edit Appointment</h3>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="form-group">
                                    <label for="client_id">Client</label>
                                    <select name="client_id" class="form-control" required>
                                        <option value="">Select Client</option>
                                        <?php
                                            $client_query = "SELECT * FROM tbl_client";
                                            $client_result = mysqli_query($conn, $client_query);
                                            while ($client = mysqli_fetch_assoc($client_result)) {
                                                echo "<option value='{$client['client_id']}' " . ($client['client_id'] == $appointment['client_id'] ? "selected" : "") . ">{$client['client_firstname']} {$client['client_lastname']}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="attorney_id">Attorney</label>
                                    <select name="attorney_id" class="form-control" required>
                                        <option value="">Select Attorney</option>
                                        <?php
                                            $attorney_query = "SELECT * FROM tbl_attorney";
                                            $attorney_result = mysqli_query($conn, $attorney_query);
                                            while ($attorney = mysqli_fetch_assoc($attorney_result)) {
                                                echo "<option value='{$attorney['attorney_id']}' " . ($attorney['attorney_id'] == $appointment['attorney_id'] ? "selected" : "") . ">{$attorney['first_name']} {$attorney['last_name']}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="service_id">Service</label>
                                    <select name="service_id" class="form-control" required>
                                        <option value="">Select Service</option>
                                        <?php
                                            $service_query = "SELECT * FROM tbl_firm_services";
                                            $service_result = mysqli_query($conn, $service_query);
                                            while ($service = mysqli_fetch_assoc($service_result)) {
                                                echo "<option value='{$service['service_id']}' " . ($service['service_id'] == $appointment['service_id'] ? "selected" : "") . ">{$service['service_name']}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="remarks">Remarks</label>
                                    <textarea name="remarks" class="form-control" rows="4" required><?php echo $appointment['remarks']; ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="0" <?php echo ($appointment['status'] == 0) ? "selected" : ""; ?>>Pending</option>
                                        <option value="1" <?php echo ($appointment['status'] == 1) ? "selected" : ""; ?>>Completed</option>
                                        <option value="2" <?php echo ($appointment['status'] == 2) ? "selected" : ""; ?>>Cancelled</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>
</html>
