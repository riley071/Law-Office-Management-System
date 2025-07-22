<!DOCTYPE html>
<html lang="en">

<?php include 'includes/header.php' ?>
<body class="hold-transition sidebar-mini layout-fixed">
   <div class="wrapper">
      
      <?php include 'includes/topbar.php' ?>
      <?php include 'includes/sidebar.php' ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
         <!-- Content Header (Page header) -->
         <div class="content-header">
            <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-sm-6">
                     <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-comments"></span> Feedbacks</h1>
                  </div>
                  <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Feedbacks</li>
                     </ol>
                  </div>
               </div>
            </div>
         </div>
         
         <!-- Main content -->
         <section class="content">
            <div class="container-fluid">
               <div class="card card-info">

               <div class="col-md-12 table-responsive"><br>
                  <table id="example1" class="table table-bordered table-hover">
                     <thead>
                        <tr>
                           <th>Customer</th>
                           <th>Message</th>
                           <th>Feedback On</th>
                           <th>Rating</th>
                           <th>Status</th>
                           <th class="text-right">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                     <tbody>
<?php
include 'includes/connection.php';

// Fetch feedback data from database
$query = "SELECT f.*, 
                 c.client_firstname, c.client_lastname, 
                 a.first_name AS attorney_firstname, a.last_name AS attorney_lastname
          FROM tbl_feedback f
          JOIN tbl_client c ON f.client_id = c.client_id
          JOIN tbl_attorney a ON f.attorney_id = a.attorney_id";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $client_name = $row['client_firstname'] . ' ' . $row['client_lastname'];
    $attorney_name = $row['attorney_firstname'] . ' ' . $row['attorney_lastname'];
    $rating = str_repeat('<span class="fa fa-star text-warning"></span>', $row['rating']);
    $status_class = $row['status'] == 'published' ? 'bg-success' : 'bg-danger';
    $status_text = ucfirst($row['status']);

    echo "
        <tr>
            <td>$client_name</td>
            <td>{$row['message']}</td>
            <td>$attorney_name</td>
            <td>$rating</td>
            <td><span class='badge $status_class'>$status_text</span></td>
            <td class='text-right'>
                <button class='btn btn-sm btn-danger' data-toggle='modal' data-target='#delete' data-id='{$row['feedback_id']}'>
                    <i class='fa fa-trash'></i> Delete
                </button>
            </td>
        </tr>";
}
?>
</tbody>

                  </table>
               </div>
            </div>
         </div>

   </section>
   </div>

   <!-- /.content-wrapper -->
   </div>
   <!-- ./wrapper -->

   <!-- Modal for Delete Confirmation -->
   <div id="delete" class="modal animated rubberBand delete-modal" role="dialog">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-body text-center">
               <img src="../asset/img/sent.png" alt="" width="50" height="46">
               <h3>Are you sure you want to delete this feedback?</h3>
               <div class="m-t-20">
                  <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                  <button type="submit" class="btn btn-danger" id="deleteFeedbackBtn">Delete</button>
               </div>
            </div>
         </div>
      </div>
   </div>

   <!-- jQuery -->
   <script src="../asset/jquery/jquery.min.js"></script>
   <script src="../asset/js/bootstrap.bundle.min.js"></script>
   <script src="../asset/js/adminlte.js"></script>

   <!-- DataTables  & Plugins -->
   <script src="../asset/tables/datatables/jquery.dataTables.min.js"></script>
   <script src="../asset/tables/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
   <script src="../asset/tables/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
   <script src="../asset/tables/datatables-buttons/js/buttons.bootstrap4.min.js"></script>

   <!-- Handle the deletion process -->
   <script>
      $(function () {
         // Initialize DataTables
         $("#example1").DataTable();
         
         // When a delete button is clicked, store the feedback ID for deletion
         var feedbackId;
         $('#delete').on('show.bs.modal', function (e) {
            feedbackId = $(e.relatedTarget).data('id');
         });

         // Confirm delete
         $('#deleteFeedbackBtn').click(function () {
            $.ajax({
               url: 'delete_feedback.php',
               type: 'POST',
               data: { id: feedbackId },
               success: function (response) {
                  if (response == 'success') {
                     $('#delete').modal('hide');
                     location.reload(); // Refresh page to reflect changes
                  } else {
                     alert('Error deleting feedback');
                  }
               }
            });
         });
      });
   </script>

</body>
</html>
