<?php include 'includes/header.php'; ?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<?php include 'includes/topbar.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="content-wrapper">
   <section class="content">
      <div class="container-fluid">
         <div class="card card-info">
            <div class="card-header">
               <h3 class="card-title">Select Case to Add Progress</h3>
            </div>
            <div class="card-body">
               <table class="table table-bordered table-hover">
                  <thead>
                     <tr>
                        <th>Case Title</th>
                        <th>Client</th>
                        <th>Attorney</th>
                        <th>Status</th>
                        <th class="text-right">Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                     include 'includes/connection.php';
                     $query = "
                        SELECT c.case_id, c.case_title, c.status, 
                               cl.client_firstname, cl.client_lastname, 
                               a.first_name AS attorney
                        FROM tbl_case c
                        JOIN tbl_client cl ON c.client_id = cl.client_id
                        JOIN tbl_attorney a ON c.attorney_id = a.attorney_id
                     ";

                     $result = mysqli_query($conn, $query);
                     while ($row = mysqli_fetch_assoc($result)) {
                        $client = $row['client_firstname'] . ' ' . $row['client_lastname'];
                        echo "<tr>
                              <td>{$row['case_title']}</td>
                              <td>{$client}</td>
                              <td>{$row['attorney']}</td>
                              <td><span class='badge badge-info'>{$row['status']}</span></td>
                              <td class='text-right'>
                                 <a href='create_case_progress.php?id={$row['case_id']}' class='btn btn-sm btn-success'>
                                    <i class='fa fa-plus'></i> Add Progress
                                 </a>
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

<?php include 'includes/footer.php'; ?>
</body>
</html>
