<?php
session_start();
include 'includes/connection.php';

$client_id = $_SESSION['client_id'];
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'includes/header.php' ?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <?php include 'includes/topbar.php' ?>
    <?php include 'includes/sidebar.php' ?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-primary"><i class="fa fa-briefcase"></i> Case Updates</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="client_dashboard.php">Home</a></li>
                            <li class="breadcrumb-item active">Case Updates</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-info">
                    <div class="card-body table-responsive">
                        <table id="casesTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Case Title</th>
                                    <th>Status</th>
                                    <th>Date Filed</th>
                                    <th>Attorney</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "
                                    SELECT cs.case_title, cs.status, cs.case_description, cs.created_at,
                                           at.first_name, at.last_name
                                    FROM tbl_case cs
                                    JOIN tbl_attorney at ON cs.attorney_id = at.attorney_id
                                    WHERE cs.client_id = $client_id
                                    ORDER BY cs.created_at DESC
                                ";

                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $attorney_name = $row['first_name'] . ' ' . $row['last_name'];
                                    echo "<tr>
                                            <td>{$row['case_title']}</td>
                                            <td>{$row['status']}</td>
                                            <td>{$row['created_at']}</td>
                                            <td>{$attorney_name}</td>
                                            <td>{$row['case_description']}</td>
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
        $('#casesTable').DataTable();
    });
</script>
</body>
</html>
