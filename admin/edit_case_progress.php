<?php 
include 'includes/header.php';
include 'includes/connection.php';

// Check if the case_id is passed in the URL
if (isset($_GET['id'])) {
    $case_id = $_GET['id'];
    
    // Query to get the current details of the case progress
    $query = "SELECT c.case_id, c.case_title, c.status, p.update_title, p.update_description, p.update_date
              FROM tbl_case c
              LEFT JOIN tbl_case_progress p ON c.case_id = p.case_id
              WHERE c.case_id = ?";
    
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $case_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            // Case progress details found, assign to variables
            $case_title = $row['case_title'];
            $status = $row['status'];
            $update_title = $row['update_title'];
            $update_description = $row['update_description'];
            $update_date = $row['update_date'];
        } else {
            echo "No case progress found.";
            exit;
        }

        mysqli_stmt_close($stmt);
    }
} else {
    echo "Invalid request.";
    exit;
}
?>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

<?php include 'includes/topbar.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="content-wrapper">
   <section class="content">
      <div class="container-fluid">
         <div class="card card-info">
            <div class="card-header"><h3 class="card-title">Edit Case Progress</h3></div>
            <div class="card-body">
               <form action="update_case_progress.php" method="POST">
                  <input type="hidden" name="case_id" value="<?php echo $case_id; ?>">
                  <div class="form-group">
                     <label for="case_title">Case Title</label>
                     <input type="text" class="form-control" id="case_title" name="case_title" value="<?php echo $case_title; ?>" readonly>
                  </div>
                  <div class="form-group">
                     <label for="status">Status</label>
                     <select class="form-control" id="status" name="status">
                        <option value="In Progress" <?php echo ($status == 'In Progress') ? 'selected' : ''; ?>>In Progress</option>
                        <option value="Completed" <?php echo ($status == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                        <option value="Pending" <?php echo ($status == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                     </select>
                  </div>
                  <div class="form-group">
                     <label for="update_title">Update Title</label>
                     <input type="text" class="form-control" id="update_title" name="update_title" value="<?php echo $update_title; ?>" required>
                  </div>
                  <div class="form-group">
                     <label for="update_description">Update Description</label>
                     <textarea class="form-control" id="update_description" name="update_description" rows="4" required><?php echo $update_description; ?></textarea>
                  </div>
                  <div class="form-group">
                     <label for="update_date">Update Date</label>
                     <input type="date" class="form-control" id="update_date" name="update_date" value="<?php echo $update_date; ?>" required>
                  </div>
                  <button type="submit" class="btn btn-primary">Update</button>
               </form>
            </div>
         </div>
      </div>
   </section>
</div>

</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
