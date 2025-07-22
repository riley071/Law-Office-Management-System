<?php
include 'includes/header.php';
include 'includes/connection.php';
session_start();

if (!isset($_SESSION['client_id'])) {
    header("Location: login.php");
    exit();
}

$client_id = $_SESSION['client_id'];

// Fetch appointments for this client with status != 0
$stmt = $conn->prepare("SELECT a.appointment_date, a.status, f.service_name, 
                        CONCAT(at.first_name, ' ', at.last_name) AS attorney_name
                        FROM tbl_appoinment a
                        LEFT JOIN tbl_attorney at ON a.attorney_id = at.attorney_id
                        LEFT JOIN tbl_firm_services f ON a.service_id = f.service_id
                        WHERE a.client_id = ? AND a.status != 0
                        ORDER BY a.appointment_date DESC");
$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Appointments</title>
    <link rel="stylesheet" href="asset/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
    <style>
        .top-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .badge {
            padding: 5px 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <?php include 'includes/topbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <div class="content-wrapper p-4">
        <div class="top-controls mb-3">
            <h3>My Appointments</h3>
            <a href="client_appointments.php" class="btn btn-primary">Book Appointment</a>
        </div>

        <div class="card">
            <div class="card-body">
                <?php if ($result->num_rows > 0): ?>
                    <table id="appointmentsTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Service</th>
                                <th>Attorney</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo date("F j, Y", strtotime($row['appointment_date'])); ?></td>
                                    <td><?php echo htmlspecialchars($row['service_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['attorney_name']); ?></td>
                                    <td>
                                        <?php
                                        switch ($row['status']) {
                                            case 1: echo "<span class='badge badge-warning'>Pending</span>"; break;
                                            case 2: echo "<span class='badge badge-success'>Confirmed</span>"; break;
                                            case 3: echo "<span class='badge badge-danger'>Cancelled</span>"; break;
                                            default: echo "<span class='badge badge-secondary'>Unknown</span>";
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No appointments found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function () {
        $('#appointmentsTable').DataTable();
    });
</script>
</body>
</html>
