<?php 
include 'includes/header.php'; 
include 'includes/connection.php';
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
               <h3 class="card-title">Create New Case</h3>
            </div>
            <div class="card-body">
               <form action="process_case_progress.php" method="POST">

                  <!-- Client Selection -->
                  <div class="form-group">
                     <label for="client_id">Select Client</label>
                     <select class="form-control" id="client_id" name="client_id" required>
                        <option value="">-- Select Client --</option>
                        <?php
                        $clientQuery = "SELECT client_id, client_firstname, client_lastname FROM tbl_client";
                        $clientResult = mysqli_query($conn, $clientQuery);
                        while ($row = mysqli_fetch_assoc($clientResult)) {
                            echo "<option value='{$row['client_id']}'>{$row['client_firstname']} {$row['client_lastname']}</option>";
                        }
                        ?>
                     </select>
                  </div>

                  <!-- Attorney Selection -->
                  <div class="form-group">
                     <label for="attorney_id">Assign Attorney</label>
                     <select class="form-control" id="attorney_id" name="attorney_id" required>
                        <option value="">-- Select Attorney --</option>
                        <?php
                        $attorneyQuery = "SELECT attorney_id, first_name FROM tbl_attorney";
                        $attorneyResult = mysqli_query($conn, $attorneyQuery);
                        while ($row = mysqli_fetch_assoc($attorneyResult)) {
                            echo "<option value='{$row['attorney_id']}'>{$row['first_name']}</option>";
                        }
                        ?>
                     </select>
                  </div>

                  <!-- Case Title -->
                  <div class="form-group">
                     <label for="case_title">Case Title</label>
                     <input type="text" class="form-control" id="case_title" name="case_title" required>
                  </div>

                  <!-- Case Status -->
                  <div class="form-group">
                     <label for="status">Case Status</label>
                     <select class="form-control" id="status" name="status" required>
                        <option value="Open">Open</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Closed">Closed</option>
                     </select>
                  </div>

                  <!-- Description -->
                  <div class="form-group">
                     <label for="description">Case Description</label>
                     <textarea name="case_description" class="form-control" rows="4" required></textarea>
         </div>

                  <button type="submit" class="btn btn-primary">Create Case</button>
               </form>
            </div>
         </div>
      </div>
   </section>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
