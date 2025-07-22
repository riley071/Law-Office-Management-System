<?php include 'includes/header.php'; ?>
<body>
<div class="wrapper">
<?php include 'includes/topbar.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="content-wrapper">
   <section class="content">
      <div class="container-fluid">
      <a href="document_upload.php" class="btn btn-primary mb-2">
                  <i class="fa fa-plus"></i> Upload Document
               </a>
         <div class="card card-info">
            <div class="card-header">
               <h3 class="card-title">Document Library</h3>
            </div>
            <div class="card-body table-responsive">

               <!-- Search Bar -->
               <div class="mb-3">
                  <input type="text" id="documentSearch" class="form-control" placeholder="Search by case title, description, or uploaded by...">
               </div>

               <table class="table table-bordered" id="documentTable">
                  <thead>
                     <tr>
                        <th>Case</th>
                        <th>Description</th>
                        <th>Uploaded By</th>
                        <th>File</th>
                        <th>Date</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                     include 'includes/connection.php';
                     $query = "SELECT d.*, c.case_title FROM tbl_documents d JOIN tbl_case c ON d.case_id = c.case_id ORDER BY d.upload_date DESC";
                     $result = mysqli_query($conn, $query);
                     while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                              <td>{$row['case_title']}</td>
                              <td>{$row['description']}</td>
                              <td>{$row['uploaded_by']}</td>
                              <td><a href='{$row['file_path']}' target='_blank'>{$row['file_name']}</a></td>
                              <td>{$row['upload_date']}</td>
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

<?php include 'includes/footer.php'; ?>
</div>

<!-- Live Search Script -->
<script>
   document.getElementById('documentSearch').addEventListener('keyup', function () {
      const value = this.value.toLowerCase();
      const rows = document.querySelectorAll('#documentTable tbody tr');

      rows.forEach(row => {
         const text = row.innerText.toLowerCase();
         row.style.display = text.includes(value) ? '' : 'none';
      });
   });
</script>

</body>
</html>
