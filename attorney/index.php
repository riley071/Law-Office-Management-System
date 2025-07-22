<?php
include 'includes/header.php';
include 'includes/connection.php';
session_start();

// Redirect if not logged in
if (!isset($_SESSION['attorney_id'])) {
    header("Location: login.php");
    exit();
}

$attorney_id = $_SESSION['attorney_id'];

// Fetch appointment count
$app_sql = "SELECT COUNT(*) AS total_appointments FROM tbl_appoinment WHERE attorney_id = ?";
$stmt = $conn->prepare($app_sql);
$stmt->bind_param("i", $attorney_id);
$stmt->execute();
$app_result = $stmt->get_result()->fetch_assoc();
$appointment_count = $app_result['total_appointments'] ?? 0;
$stmt->close();

// Fetch active case count
$case_sql = "SELECT COUNT(*) AS total_cases FROM tbl_case WHERE attorney_id = ? AND status IN ('Open', 'In Progress')";
$stmt = $conn->prepare($case_sql);
$stmt->bind_param("i", $attorney_id);
$stmt->execute();
$case_result = $stmt->get_result()->fetch_assoc();
$active_cases = $case_result['total_cases'] ?? 0;
$stmt->close();

// Fetch services count (adjust logic if needed)
$service_sql = "SELECT COUNT(*) AS total_services 
                FROM tbl_firm_services 
                WHERE attorney_id = ?";

$stmt = $conn->prepare($service_sql);
$stmt->bind_param("i", $attorney_id);
$stmt->execute();
$service_result = $stmt->get_result()->fetch_assoc();
$total_services = $service_result['total_services'] ?? 0;
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <?php include 'includes/topbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0" style="color: rgb(31,108,163);">
                            <span class="fa fa-tachometer-alt"></span> Attorney Dashboard
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- Appointments -->
                    <div class="col-12 col-sm-6 col-md-6">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-calendar"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Number of Appointments</span>
                                <span class="info-box-number"><?php echo $appointment_count; ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Active Cases -->
                    <div class="col-12 col-sm-6 col-md-6">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-briefcase"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Number of Active Cases</span>
                                <span class="info-box-number"><?php echo $active_cases; ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Services -->
                    <div class="col-12 col-sm-6 col-md-6 offset-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-hand-holding-heart"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Number of Services</span>
                                <span class="info-box-number"><?php echo $total_services; ?></span>
                            </div>
                        </div>
                    </div>
                </div> <!-- /.row -->
            </div> <!-- /.container-fluid -->
        </section> <!-- /.content -->
    </div> <!-- /.content-wrapper -->

    <?php include 'includes/footer.php'; ?>
</div>
</body>
</html>
