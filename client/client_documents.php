<?php
session_start();
include 'includes/connection.php';

// Ensure the client is logged in
if (!isset($_SESSION['client_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch the logged-in client's ID
$client_id = $_SESSION['client_id'];

?>

<!DOCTYPE html>
<html lang="en">
<?php include 'includes/header.php'; ?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <?php include 'includes/topbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-primary"><i class="fa fa-file-alt"></i> My Documents</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="client_dashboard.php">Home</a></li>
                            <li class="breadcrumb-item active">Documents</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <a href="add_document.php" class="btn btn-primary mb-3"><i class="fa fa-upload"></i> Add Document</a>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-info">
                    
                    <div class="card-body table-responsive">
                        <table id="documentsTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Document</th>  <!-- Updated column name -->
                                    <th>Uploaded On</th>
                                    <th>Case</th>
                                    <th>File</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Query to fetch documents for the logged-in client
                                $query = "
                                    SELECT d.*, cs.case_title 
                                    FROM tbl_documents d
                                    LEFT JOIN tbl_case cs ON d.case_id = cs.case_id
                                    WHERE d.client_id = ?  -- Filter by client_id
                                    ORDER BY d.upload_date DESC
                                ";

                                // Prepare and execute the query
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("i", $client_id);  // Bind client_id
                                $stmt->execute();
                                $result = $stmt->get_result();

                                // Display documents
                                while ($row = $result->fetch_assoc()) {
                                    $file_link = "../uploads/documents/" . $row['file_name'];
                                    // Use file_name as the document title
                                    echo "<tr>
                                            <td>{$row['file_name']}</td>  <!-- Display file_name instead of document_title -->
                                            <td>{$row['upload_date']}</td>
                                            <td>{$row['case_title']}</td>
                                            <td><a href='{$file_link}' target='_blank' class='btn btn-sm btn-info'><i class='fa fa-download'></i> Download</a></td>
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

<script src="../asset/jquery/jquery.min.js"></script>
<script src="../asset/js/bootstrap.bundle.min.js"></script>
<script src="../asset/js/adminlte.js"></script>
<script src="../asset/tables/datatables/jquery.dataTables.min.js"></script>
<script src="../asset/tables/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(function () {
        $('#documentsTable').DataTable();
    });
</script>
</body>
</html>
