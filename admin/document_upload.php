<?php include 'includes/header.php'; ?>
<body>
<div class="wrapper">
<?php include 'includes/topbar.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="content-wrapper">
   <section class="content">
      <div class="container-fluid">
         <div class="card card-info">
            <div class="card-header">
               <h3 class="card-title">Upload Legal Document</h3>
            </div>
            <div class="card-body">
               <form action="upload_document.php" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                     <label>Case</label>
                     <select name="case_id" class="form-control" required>
                        <?php
                        include 'includes/connection.php';
                        $query = mysqli_query($conn, "SELECT * FROM tbl_case");
                        while ($row = mysqli_fetch_assoc($query)) {
                           echo "<option value='{$row['case_id']}'>{$row['case_title']}</option>";
                        }
                        ?>
                     </select>
                  </div>
                  <div class="form-group">
                     <label>Description</label>
                     <textarea name="description" class="form-control" required></textarea>
                  </div>
                  <div class="form-group">
                     <label>Upload File</label>
                     <input type="file" name="document" class="form-control" required>
                  </div>
                  <input type="hidden" name="uploaded_by" value="admin">
                  <button type="submit" class="btn btn-primary">Upload</button>
               </form>
            </div>
         </div>
      </div>
   </section>
</div>


<?php include 'includes/footer.php'; ?>
</div>
</body>
</html>
