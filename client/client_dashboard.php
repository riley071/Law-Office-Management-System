<?php
include 'includes/header.php';
include 'includes/connection.php';
session_start();

// Check if the client is logged in
if (!isset($_SESSION['client_id'])) {
    header("Location: login.php");
    exit();
}

$client_id = $_SESSION['client_id'];

// Total appointments (excluding status = 0)
$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM tbl_appoinment WHERE client_id = ? AND status != 0");
$stmt->bind_param("i", $client_id);
$stmt->execute();
$total_appointments = $stmt->get_result()->fetch_assoc()['total'];
$stmt->close();

// Upcoming appointments (excluding status = 0)
$stmt = $conn->prepare("SELECT * FROM tbl_appoinment WHERE client_id = ? AND status != 0 AND appointment_date >= CURDATE() ORDER BY appointment_date ASC LIMIT 5");
$stmt->bind_param("i", $client_id);
$stmt->execute();
$upcoming_appointments = $stmt->get_result();
$stmt->close();

// Case updates
$stmt = $conn->prepare("SELECT * FROM tbl_case WHERE client_id = ? ORDER BY created_at DESC LIMIT 5");
$stmt->bind_param("i", $client_id);
$stmt->execute();
$case_updates = $stmt->get_result();
$stmt->close();

// Function to get attorney's name
function getAttorneyName($attorney_id, $conn) {
    $stmt = $conn->prepare("SELECT CONCAT(first_name, ' ', last_name) AS fullname FROM tbl_attorney WHERE attorney_id = ?");
    $stmt->bind_param("i", $attorney_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $attorney = $result->fetch_assoc();
    return $attorney['fullname'];
}

// Function to get service name
function getServiceName($service_id, $conn) {
    $stmt = $conn->prepare("SELECT service_name FROM tbl_firm_services WHERE service_id = ?");
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $service = $result->fetch_assoc();
    return $service['service_name'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css">
    <link rel="stylesheet" href="asset/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <?php include 'includes/topbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <div class="content-wrapper p-3">
        <h3>Welcome to Your Dashboard</h3>

        <div class="row">
            <div class="col-md-4">
                <div class="info-box bg-info">
                    <span class="info-box-icon"><i class="fas fa-calendar"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Appointments</span>
                        <span class="info-box-number"><?php echo $total_appointments; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Appointments -->
        <div class="card mb-4">
            <div class="card-header bg-warning">
                <h5 class="card-title">Upcoming Appointments</h5>
            </div>
            <div class="card-body">
                <?php if ($upcoming_appointments->num_rows > 0): ?>
                    <ul class="list-group">
                        <?php while ($row = $upcoming_appointments->fetch_assoc()): ?>
                            <li class="list-group-item">
                                <strong><?php echo date("F j, Y", strtotime($row['appointment_date'])); ?>:</strong>
                                <p>Attorney: <?php echo getAttorneyName($row['attorney_id'], $conn); ?></p>
                                <p>Service: <?php echo getServiceName($row['service_id'], $conn); ?></p>
                                Status:
                                <?php
                                    switch ($row['status']) {
                                        case 1: echo "<span class='badge bg-primary'>Pending</span>"; break;
                                        case 2: echo "<span class='badge bg-success'>Confirmed</span>"; break;
                                        case 3: echo "<span class='badge bg-danger'>Cancelled</span>"; break;
                                        default: echo "<span class='badge bg-secondary'>Unknown</span>";
                                    }
                                ?>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p>No upcoming appointments.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Case Updates -->
        <div class="card mb-4">
            <div class="card-header bg-success">
                <h5 class="card-title">Recent Case Updates</h5>
            </div>
            <div class="card-body">
                <?php if ($case_updates->num_rows > 0): ?>
                    <ul class="list-group">
                        <?php while ($row = $case_updates->fetch_assoc()): ?>
                            <li class="list-group-item">
                                <strong>Case #<?php echo $row['case_id']; ?>:</strong>
                                <?php echo $row['status']; ?> - Created on <?php echo date("F j, Y", strtotime($row['created_at'])); ?>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p>No recent case updates.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Calendar -->
        <div class="card">
            <div class="card-header bg-primary">
                <h5 class="card-title text-white">Appointment Calendar</h5>
            </div>
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'dayGridMonth',
        events: 'client_appointments_feed.php'  // This file should return JSON data for the calendar
    });
    calendar.render();
});
</script>
</body>
</html>
