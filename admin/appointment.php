<!-- appointments.php -->

<!DOCTYPE html>
<html lang="en">

<?php include 'includes/header.php'?>
<body class="hold-transition sidebar-mini layout-fixed">
   <div class="wrapper">
      <?php include 'includes/topbar.php'?>
      <?php include 'includes/sidebar.php'?>

      <div class="content-wrapper">
         <div class="content-header">
            <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-sm-6">
                        <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-calendar-alt"></span> Appointments</h1>
                  </div>
                  <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Appointments</li>
                     </ol>
                  </div>
               </div>
            </div>
         </div>
         
         <section class="content">
            <div class="container-fluid">
               <a href="appointment_add.php" class="btn btn-primary mb-2">
                  <i class="fa fa-plus"></i> Add Appointment
               </a>
               
               <div class="card card-info">
                  <div class="col-md-12 table-responsive">
                     <table id="example1" class="table table-bordered table-hover">
                        <thead>
                           <tr>
                              <th>Ref No.</th>
                              <th>Customer</th>
                              <th>Contact</th>
                              <th>Email</th>
                              <th>Service Name</th>
                              <th>Attorney</th>
                              <th>Remarks</th>
                              <th>Status</th>
                              <th>Actions</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                              // Database connection
                              include 'includes/connection.php';

                              // Fetch appointments
                              $query = "SELECT * FROM tbl_appoinment";
                              $result = mysqli_query($conn, $query);

                              while ($row = mysqli_fetch_assoc($result)) {
                                 $client_id = $row['client_id'];
                                 $attorney_id = $row['attorney_id'];
                                 $service_id = $row['service_id'];

                                 // Fetch related client, attorney, and service details
                                 $client_query = "SELECT * FROM tbl_client WHERE client_id = '$client_id'";
                                 $client_result = mysqli_query($conn, $client_query);
                                 $client = mysqli_fetch_assoc($client_result);

                                 $attorney_query = "SELECT * FROM tbl_attorney WHERE attorney_id = '$attorney_id'";
                                 $attorney_result = mysqli_query($conn, $attorney_query);
                                 $attorney = mysqli_fetch_assoc($attorney_result);

                                 $service_query = "SELECT * FROM tbl_firm_services WHERE service_id = '$service_id'";
                                 $service_result = mysqli_query($conn, $service_query);
                                 $service = mysqli_fetch_assoc($service_result);
                           ?>
                              <tr>
                                 <td><?php echo $row['reference_number']; ?></td>
                                 <td><?php echo $client['client_firstname'] . ' ' . $client['client_lastname']; ?></td>
                                 <td><?php echo $client['contact']; ?></td>
                                 <td><?php echo $client['email_address']; ?></td>
                                 <td><?php echo $service['service_name']; ?></td>
                                 <td><?php echo $attorney['first_name'] . ' ' . $attorney['last_name']; ?></td>
                                 <td><?php echo $row['remarks']; ?></td>
                                 <td>
                                    <span class="badge bg-<?php echo $row['status'] == 1 ? 'success' : ($row['status'] == 2 ? 'danger' : 'warning'); ?>">
                                       <?php echo $row['status'] == 1 ? 'Completed' : ($row['status'] == 2 ? 'Cancelled' : 'Pending'); ?>
                                    </span>
                                 </td>
                                 <td>
                                    <a href="appointment_edit.php?id=<?php echo $row['appointment_id']; ?>" class="btn btn-sm btn-info">
                                       <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a href="appointment_delete.php?id=<?php echo $row['appointment_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this appointment?')">
                                       <i class="fa fa-trash"></i> Delete
                                    </a>
                                 </td>
                              </tr>
                           <?php } ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </section>
      </div>
   </div>

   <!-- jQuery -->
   <script src="../asset/jquery/jquery.min.js"></script>
   <script src="../asset/js/bootstrap.bundle.min.js"></script>
   <script src="../asset/js/adminlte.js"></script>
   <script src="../asset/tables/datatables/jquery.dataTables.min.js"></script>
   <script src="../asset/tables/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
   <script>
      $(function () {
         $("#example1").DataTable();
      });
   </script>
</body>
</html>
