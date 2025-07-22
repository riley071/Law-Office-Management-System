<?php
include 'includes/connection.php'; // Database connection

// Get the service ID from the URL
if (isset($_GET['id'])) {
    $service_id = $_GET['id'];
    
    // Fetch the service details from the database
    $service_query = "SELECT s.service_id, s.service_name, s.description, s.rate, s.attorney_id, a.first_name AS attorney_firstname, a.last_name AS attorney_lastname
                      FROM tbl_firm_services s
                      JOIN tbl_attorney a ON s.attorney_id = a.attorney_id
                      WHERE s.service_id = '$service_id'";
    $result = mysqli_query($conn, $service_query);
    
    if (mysqli_num_rows($result) > 0) {
        $service = mysqli_fetch_assoc($result);
    } else {
        header("Location: service.php?error=Service not found");
        exit;
    }
}

// Handle the form submission for editing the service
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_name = mysqli_real_escape_string($conn, $_POST['service_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $rate = mysqli_real_escape_string($conn, $_POST['rate']);
    $attorney_id = mysqli_real_escape_string($conn, $_POST['attorney_id']);
    
    // Update the service details in the database
    $update_query = "UPDATE tbl_firm_services 
                     SET service_name = '$service_name', description = '$description', rate = '$rate', attorney_id = '$attorney_id'
                     WHERE service_id = '$service_id'";
    
    if (mysqli_query($conn, $update_query)) {
        header("Location: services.php?message=Service updated successfully");
        exit;
    } else {
        header("Location: edit-service.php?id=$service_id&error=Failed to update service");
        exit;
    }
}

// Fetch attorneys for the dropdown
$attorney_query = "SELECT attorney_id, first_name, last_name FROM tbl_attorney";
$attorney_result = mysqli_query($conn, $attorney_query);

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
                        <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-edit"></span> Edit Service</h1>
                  </div>
                  <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit Service</li>
                     </ol>
                  </div>
               </div>
            </div>
         </div>

         <!-- Main content -->
         <section class="content">
            <div class="container-fluid">
               <div class="card card-info">
                  <div class="card-header">
                     <h3 class="card-title">Edit Service Details</h3>
                  </div>
                  <div class="card-body">
                     <?php
                     if (isset($_GET['error'])) {
                         echo '<div class="alert alert-danger" role="alert">' . $_GET['error'] . '</div>';
                     }
                     ?>
                     <form method="POST">
                        <div class="form-group">
                           <label for="service_name">Service Name</label>
                           <input type="text" class="form-control" id="service_name" name="service_name" value="<?php echo $service['service_name']; ?>" required>
                        </div>
                        <div class="form-group">
                           <label for="description">Description</label>
                           <textarea class="form-control" id="description" name="description" required><?php echo $service['description']; ?></textarea>
                        </div>
                        <div class="form-group">
                           <label for="rate">Rate</label>
                           <input type="text" class="form-control" id="rate" name="rate" value="<?php echo $service['rate']; ?>" required>
                        </div>
                        <div class="form-group">
                           <label for="attorney_id">Attorney</label>
                           <select class="form-control" id="attorney_id" name="attorney_id" required>
                              <option value="">Select Attorney</option>
                              <?php while ($attorney = mysqli_fetch_assoc($attorney_result)) { ?>
                                 <option value="<?php echo $attorney['attorney_id']; ?>" <?php echo ($service['attorney_id'] == $attorney['attorney_id']) ? 'selected' : ''; ?>>
                                    <?php echo $attorney['first_name'] . " " . $attorney['last_name']; ?>
                                 </option>
                              <?php } ?>
                           </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                     </form>
                  </div>
               </div>
            </div>
         </section>
      </div>
   </body>

   <script src="../asset/jquery/jquery.min.js"></script>
   <script src="../asset/js/bootstrap.bundle.min.js"></script>
   <script src="../asset/js/adminlte.js"></script>
</html>
