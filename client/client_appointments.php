<?php
session_start();
include 'includes/connection.php';

// Check if client is logged in
if (!isset($_SESSION['client_id'])) {
    header("Location: login.php");
    exit();
}

$client_id = $_SESSION['client_id'];

// Fetch available services
$services_query = "SELECT service_id, service_name FROM tbl_firm_services";
$services_result = mysqli_query($conn, $services_query);

// Fetch attorneys using correct column names from your table structure
$attorney_query = "SELECT attorney_id, CONCAT(first_name, ' ', last_name) AS fullname FROM tbl_attorney";
$attorney_result = mysqli_query($conn, $attorney_query);
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'includes/header.php'; ?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <?php include 'includes/topbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-calendar-plus"></span> Book Appointment</h1>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-info">
                    <div class="card-body">
                        <form action="process_appointment.php" method="POST">
                            <div class="form-group">
                                <label>Service</label>
                                <select name="service_id" class="form-control" required>
                                    <option value="">Select Service</option>
                                    <?php while ($row = mysqli_fetch_assoc($services_result)) {
                                        echo "<option value='{$row['service_id']}'>{$row['service_name']}</option>";
                                    } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Preferred Attorney</label>
                                <select name="attorney_id" class="form-control" required>
                                    <option value="">Select Attorney</option>
                                    <?php while ($row = mysqli_fetch_assoc($attorney_result)) {
                                        echo "<option value='{$row['attorney_id']}'>{$row['fullname']}</option>";
                                    } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Appointment Date</label>
                                <input type="date" name="appointment_date" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Remarks</label>
                                <textarea name="remarks" class="form-control" placeholder="Describe your issue or reason for booking" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Booking</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<script src="../asset/jquery/jquery.min.js"></script>
<script src="../asset/js/bootstrap.bundle.min.js"></script>
<script src="../asset/js/adminlte.js"></script>
</body>
</html>
