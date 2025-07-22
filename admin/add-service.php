<?php
include 'includes/connection.php'; // Database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $service_name = mysqli_real_escape_string($conn, $_POST['service_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $rate = mysqli_real_escape_string($conn, $_POST['rate']);
    $attorney_id = mysqli_real_escape_string($conn, $_POST['attorney_id']);

    // Insert the service into the database
    $insert_query = "INSERT INTO tbl_firm_services (service_name, description, rate, attorney_id) 
                     VALUES ('$service_name', '$description', '$rate', '$attorney_id')";

    if (mysqli_query($conn, $insert_query)) {
        header("Location: services.php?message=Service added successfully");
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'includes/header.php' ?>
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
                     <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-hand-holding-heart"></span> Add Service</h1>
                  </div>
                  <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Add Service</li>
                     </ol>
                  </div>
               </div>
            </div>
         </div>
         <!-- /.content-header -->

         <!-- Main content -->
         <section class="content">
            <div class="container-fluid">
               <div class="card card-info">
                  <div class="card-body">
                     <!-- Check if there's any error -->
                     <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                     <?php endif; ?>

                     <form method="POST" action="add-service.php">
                        <div class="form-group">
                           <label for="service_name">Service Name</label>
                           <input type="text" class="form-control" id="service_name" name="service_name" required>
                        </div>

                        <div class="form-group">
                           <label for="description">Description</label>
                           <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                        </div>

                        <div class="form-group">
                           <label for="rate">Rate</label>
                           <input type="number" class="form-control" id="rate" name="rate" required>
                        </div>

                        <div class="form-group">
                           <label for="attorney_id">Attorney</label>
                           <select class="form-control" id="attorney_id" name="attorney_id" required>
                              <option value="">Select an Attorney</option>
                              <?php
                                 // Get all attorneys to populate the select options
                                 $attorney_query = "SELECT attorney_id, first_name, last_name FROM tbl_attorney";
                                 $attorney_result = mysqli_query($conn, $attorney_query);
                                 while ($attorney = mysqli_fetch_assoc($attorney_result)) {
                                     echo "<option value='{$attorney['attorney_id']}'>{$attorney['first_name']} {$attorney['last_name']}</option>";
                                 }
                              ?>
                           </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Add Service</button>
                        <a href="service.php" class="btn btn-secondary">Cancel</a>
                     </form>
                  </div>
               </div>
            </div>
         </section>
      </div>
   </body>
</html>
