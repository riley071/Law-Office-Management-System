<?php
include 'includes/header.php';
include 'includes/connection.php'; // Adjust path to your DB connection file
?>

<!DOCTYPE html>
<html lang="en">
   <body class="hold-transition sidebar-mini layout-fixed">
      <div class="wrapper">
         <?php include 'includes/topbar.php'?>
         <?php include 'includes/sidebar.php'?>

         <!-- Content Wrapper -->
         <div class="content-wrapper">
            <div class="content-header">
               <div class="container-fluid">
                  <div class="row mb-2">
                     <div class="col-sm-6">
                        <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-hand-holding-heart"></span> Services</h1>
                     </div>
                     <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                           <li class="breadcrumb-item"><a href="#">Home</a></li>
                           <li class="breadcrumb-item active">Services</li>
                        </ol>
                     </div>
                  </div>
               </div>
            </div>

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
                                 <th>Rate (MWK)</th>
                                 <th class="text-right">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                              $query = "SELECT s.*, a.first_name, a.middle_name, a.last_name 
                                        FROM tbl_firm_services s
                                        JOIN tbl_attorney a ON s.attorney_id = a.attorney_id";

                              $result = mysqli_query($conn, $query);

                              while ($row = mysqli_fetch_assoc($result)) {
                                 $attorney_name = "Atty. " . $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'];
                                 echo "<tr>";
                                 echo "<td>{$attorney_name}</td>";
                                 echo "<td>{$row['service_name']}</td>";
                                 echo "<td>{$row['description']}</td>";
                                 echo "<td>" . number_format($row['rate'], 2) . "</td>";
                                 echo "<td class='text-right'>
                                    <a class='btn btn-sm btn-success' href='edit_service.php?id={$row['service_id']}'><i class='fa fa-edit'></i> edit</a>
                                    <a class='btn btn-sm btn-danger' href='#' data-toggle='modal' data-target='#deleteModal{$row['service_id']}'><i class='fa fa-trash-alt'></i> delete</a>
                                 </td>";
                                 echo "</tr>";

                                 // Delete modal per row
                                 echo "<div id='deleteModal{$row['service_id']}' class='modal fade'>
                                          <div class='modal-dialog modal-dialog-centered'>
                                             <div class='modal-content'>
                                                <div class='modal-body text-center'>
                                                   <img src='../asset/img/sent.png' alt='' width='50' height='46'>
                                                   <h3>Are you sure you want to delete this service?</h3>
                                                   <div class='m-t-20'>
                                                      <a href='#' class='btn btn-white' data-dismiss='modal'>Cancel</a>
                                                      <a href='delete_service.php?id={$row['service_id']}' class='btn btn-danger'>Delete</a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>";
                              }
                              ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </section>
         </div>
      </div>

      <!-- Scripts -->
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
