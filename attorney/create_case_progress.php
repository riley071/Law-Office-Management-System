<?php 
include 'includes/header.php'; 
include 'includes/connection.php';

// Check if case ID is provided
if (isset($_GET['id'])) {
    $case_id = $_GET['id'];

    // Fetch case details
    $query = "SELECT c.case_title, cl.client_firstname, cl.client_lastname, a.first_name AS attorney, c.status
              FROM tbl_case c
              JOIN tbl_client cl ON c.client_id = cl.client_id
              JOIN tbl_attorney a ON c.attorney_id = a.attorney_id
              WHERE c.case_id = ?";

    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $case_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        // Check if the case exists
        if (mysqli_num_rows($result) > 0) {
            $case = mysqli_fetch_assoc($result);
        } else {
            echo "No case found with the provided ID.";
            exit;
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error fetching case details.";
        exit;
    }
} else {
    echo "No Case ID provided.";
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
            <div class="card-header">
               <h3 class="card-title">Add Progress for Case: <?php echo $case['case_title']; ?></h3>
            </div>
            <div class="card-body">
               <form action="process_case_progress.php" method="POST">
                  <input type="hidden" name="case_id" value="<?php echo $case_id; ?>">

                  <!-- Case Status Dropdown -->
                  <div class="form-group">
                     <label for="case_status">Case Status</label>
                     <select class="form-control" id="case_status" name="case_status" required>
                        <option value="Open" <?php echo ($case['status'] == 'Open') ? 'selected' : ''; ?>>Open</option>
                        <option value="In Progress" <?php echo ($case['status'] == 'In Progress') ? 'selected' : ''; ?>>In Progress</option>
                        <option value="Closed" <?php echo ($case['status'] == 'Closed') ? 'selected' : ''; ?>>Closed</option>
                     </select>
                  </div>

                  <!-- Update Title -->
                  <div class="form-group">
                     <label for="update_title">Update Title</label>
                     <input type="text" class="form-control" id="update_title" name="update_title" required>
                  </div>

                  <!-- Update Description -->
                  <div class="form-group">
                     <label for="update_description">Update Description</label>
                     <textarea class="form-control" id="update_description" name="update_description" rows="4" required></textarea>
                  </div>

                  <!-- Update Date -->
                  <div class="form-group">
                     <label for="update_date">Update Date</label>
                     <input type="date" class="form-control" id="update_date" name="update_date" required>
                  </div>

                  <button type="submit" class="btn btn-primary">Save Progress</button>
               </form>
            </div>
         </div>
      </div>
   </section>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
