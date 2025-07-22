<?php include 'includes/header.php'; ?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

<?php include 'includes/topbar.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="content-wrapper">
   <section class="content">
      <div class="container-fluid">
      <a href="add-case.php" class="btn btn-primary mb-2">
                  <i class="fa fa-plus"></i> Add Case
               </a>
         <div class="card card-info">
            <div class="card-header">
               <h3 class="card-title">Case Progress Tracker</h3>
            </div>
            <div class="card-body">
               <table class="table table-bordered table-hover">
                  <thead>
                     <tr>
                        <th>Case Title</th>
                        <th>Client</th>
                        <th>Attorney</th>
                        <th>Status</th>
                        <th>Updates</th>
                        <th>Last Updated</th>
                        <th class="text-right">Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                     include 'includes/connection.php';
                     
                     $query = "
                        SELECT 
                            c.case_id, 
                            c.case_title, 
                            COALESCE(c.status, 'No Status') AS status, 
                            cl.client_firstname, 
                            cl.client_lastname, 
                            a.first_name, 
                            MAX(p.update_date) AS last_update, 
                            GROUP_CONCAT(p.update_title ORDER BY p.update_date DESC SEPARATOR '<br>') AS updates
                        FROM tbl_case c
                        JOIN tbl_client cl ON c.client_id = cl.client_id
                        JOIN tbl_attorney a ON c.attorney_id = a.attorney_id
                        LEFT JOIN tbl_case_progress p ON c.case_id = p.case_id
                        GROUP BY c.case_id, c.case_title, c.status, cl.client_firstname, cl.client_lastname, a.first_name
                     ";

                     $result = mysqli_query($conn, $query);
                     while ($row = mysqli_fetch_assoc($result)) {
                        $client_name = $row['client_firstname'] . ' ' . $row['client_lastname'];
                        $updates = !empty($row['updates']) ? $row['updates'] : '<em>No updates yet</em>';
                        $last_updated = !empty($row['last_update']) ? $row['last_update'] : '<em>Not available</em>';

                        echo "<tr>
                              <td>{$row['case_title']}</td>
                              <td>{$client_name}</td>
                              <td>{$row['first_name']}</td>
                              <td><span class='badge badge-info'>{$row['status']}</span></td>
                              <td style='max-width: 200px; word-wrap: break-word;'>{$updates}</td>
                              <td>{$last_updated}</td>
                              <td class='text-right'>
                                 <a href='edit_case_progress.php?id={$row['case_id']}' class='btn btn-sm btn-primary'><i class='fa fa-edit'></i> Edit</a>
                                 <button class='btn btn-sm btn-danger delete-btn' data-id='{$row['case_id']}'><i class='fa fa-trash'></i> Delete</button>
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

</div>

<!-- Delete Modal -->
<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Confirm Deletion</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <p>Are you sure you want to delete this case progress record?</p>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
         </div>
      </div>
   </div>
</div>

<script>
   let deleteCaseId = null;

   // Trigger delete modal and store the case id
   document.querySelectorAll('.delete-btn').forEach(btn => {
      btn.addEventListener('click', function () {
         deleteCaseId = this.getAttribute('data-id');
         $('#deleteModal').modal('show');
      });
   });

   // Confirm deletion
   document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
      if (deleteCaseId) {
         fetch(`delete_case_progress.php?id=${deleteCaseId}`, {
            method: 'GET'
         })
         .then(res => res.text())
         .then(data => {
            location.reload();  // Reload to show changes
         });
      }
   });
</script>

<?php include 'includes/footer.php'; ?>
</body>
</html>
