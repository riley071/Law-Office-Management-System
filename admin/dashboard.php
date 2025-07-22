<?php
session_start();
include 'includes/connection.php'; // your DB connection file

// Redirect to login if not logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch counts from database
$law_offices = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM tbl_firm"))['total'];
$attorneys = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM tbl_attorney"))['total'];
$services = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM tbl_firm_services"))['total'];
$appointments = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM tbl_appoinment"))['total'];
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'includes/header.php'?>
     <body class="hold-transition sidebar-mini layout-fixed">
      <div class="wrapper">

         <?php include 'includes/topbar.php'?>
         <?php include 'includes/sidebar.php'?>

         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
               <div class="container-fluid">
                  <div class="row mb-2">
                     <div class="col-sm-6">
                        <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-tachometer-alt"></span> Dashboard</h1>
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

            <!-- Main content -->
            <section class="content">
               <div class="container-fluid">
                  <div class="row">
                     <div class="col-12 col-sm-6 col-md-6">
                        <div class="info-box">
                          <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-building"></i></span>
                          <div class="info-box-content">
                            <span class="info-box-text">Number of Law Office</span>
                            <span class="info-box-number"><?= $law_offices ?></span>
                          </div>
                        </div>
                      </div>

                      <div class="col-12 col-sm-6 col-md-6">
                        <div class="info-box">
                          <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-tie"></i></span>
                          <div class="info-box-content">
                            <span class="info-box-text">Number of Attorney</span>
                            <span class="info-box-number"><?= $attorneys ?></span>
                          </div>
                        </div>
                      </div>

                      <div class="clearfix hidden-md-up"></div>

                      <div class="col-12 col-sm-6 col-md-6">
                        <div class="info-box mb-3">
                          <span class="info-box-icon bg-success elevation-1"><i class="fas fa-hand-holding-heart"></i></span>
                          <div class="info-box-content">
                            <span class="info-box-text">Number of Services</span>
                            <span class="info-box-number"><?= $services ?></span>
                          </div>
                        </div>
                      </div>

                      <div class="clearfix hidden-md-up"></div>

                      <div class="col-12 col-sm-6 col-md-6">
                        <div class="info-box mb-3">
                          <span class="info-box-icon bg-indigo elevation-1"><i class="fas fa-calendar-alt"></i></span>
                          <div class="info-box-content">
                            <span class="info-box-text">Number of Appointment</span>
                            <span class="info-box-number"><?= $appointments ?></span>
                          </div>
                        </div>
                      </div>
                  </div>
               </div>
            </section>
         </div>
      </div>
      
<?php include 'includes/footer.php'?>
   </body>
</html>
