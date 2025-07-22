<!DOCTYPE html>
<html lang="en">

<?php include 'includes/header.php'?>
   <body class="hold-transition sidebar-mini layout-fixed">
      <div class="wrapper">
         
        <?php include 'includes/topbar.php'?>
        <?php include 'includes/sidebar.php'?>
        <?php include 'includes/connection.php'?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
         <!-- Content Header (Page header) -->
         <div class="content-header">
            <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-sm-6">
                        <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-hand-holding-heart"></span> Services</h1>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Office</li>
                     </ol>
                  </div>
                  <a class="btn btn-sm elevation-2" href="add-service.php" style="margin-top: 20px;margin-left: 10px;background-color: #05445E;color: #ddd;"><i
                        class="fa fa-plus"></i>
                     Add New</a>
                  <!-- /.col -->
               </div>
               <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
         </div>
         <!-- /.content-header -->
         <!-- Main content -->
         <section class="content">
            <div class="container-fluid">
               <div class="card card-info">

               <div class="col-md-12 table-responsive"><br>
                  <table id="example1" class="table table-bordered table-hover">
                     <thead>
                        <tr>
                           <th>Attorney Name</th>
                           <th>Service Name</th>
                           <th>Description</th>
                           <th>Rate</th>
                           <th class="text-right">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                           // Assuming a connection to the database is already established
                           $service_query = "SELECT s.service_id, s.service_name, s.description, s.rate, a.first_name AS attorney_firstname, a.last_name AS attorney_lastname
                                             FROM tbl_firm_services s
                                             JOIN tbl_attorney a ON s.attorney_id = a.attorney_id";
                           $result = mysqli_query($conn, $service_query);

                           while ($row = mysqli_fetch_assoc($result)) {
                              echo "<tr>
                                       <td>{$row['attorney_firstname']} {$row['attorney_lastname']}</td>
                                       <td>{$row['service_name']}</td>
                                       <td>{$row['description']}</td>
                                       <td>{$row['rate']}</td>
                                       <td class='text-right'>
                                          <a class='btn btn-sm btn-success' href='edit-service.php?id={$row['service_id']}'><i class='fa fa-edit'></i> Edit</a>
                                          <a class='btn btn-sm btn-danger' href='#' data-toggle='modal' data-target='#deleteModal' data-service-id='{$row['service_id']}'><i class='fa fa-trash-alt'></i> Delete</a>
                                       </td>
                                    </tr>";
                           }
                        ?>
                        <?php
                           if (isset($_GET['message'])) {
                               echo '<div class="alert alert-success" role="alert">' . $_GET['message'] . '</div>';
                           } elseif (isset($_GET['error'])) {
                               echo '<div class="alert alert-danger" role="alert">' . $_GET['error'] . '</div>';
                           }
                        ?>
                     </tbody>
                  </table>
               </div>
            </div>
      </div>

   <!-- /.container-fluid -->
   </section>
   <!-- /.content -->
   </div>
   <!-- /.content-wrapper -->
   </div>
   <!-- ./wrapper -->
   
   <!-- Delete Modal -->
   <div id="deleteModal" class="modal fade" role="dialog">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-body text-center">
               <img src="../asset/img/sent.png" alt="" width="50" height="46">
               <h3>Are you sure you want to delete this service?</h3>
               <div class="m-t-20">
                  <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                  <a href="#" class="btn btn-danger" id="deleteServiceBtn">Delete</a>
               </div>
            </div>
         </div>
      </div>
   </div>

   <!-- jQuery -->
   <script src="../asset/jquery/jquery.min.js"></script>
   <script src="../asset/js/bootstrap.bundle.min.js"></script>
   <script src="../asset/js/adminlte.js"></script>
   <!-- DataTables & Plugins -->
   <script src="../asset/tables/datatables/jquery.dataTables.min.js"></script>
   <script src="../asset/tables/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
   <script src="../asset/tables/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
   <script src="../asset/tables/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
   <script>
      $(function () {
         $("#example1").DataTable();
      });

      // Deleting the service
      $('#deleteModal').on('show.bs.modal', function (e) {
         var serviceId = $(e.relatedTarget).data('service-id');
         $('#deleteServiceBtn').attr('href', 'delete-service.php?id=' + serviceId);
      });
   </script>
</body>

</html>
