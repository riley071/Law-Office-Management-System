<?php
session_start();
include 'includes/connection.php';

// Get attorney ID from session
$attorney_id = $_SESSION['attorney_id'];
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
                        <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-users"></span> My Clients</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Clients</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-info">
                    <div class="col-md-12 table-responsive"><br>
                        <table id="clientsTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Client Name</th>
                                    <th>Contact</th>
                                    <th>Email</th>
                                    <th>Appointments</th>
                                    <th>Cases</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "
                                    SELECT DISTINCT 
                                        c.client_id,
                                        c.client_firstname,
                                        c.client_middlename,
                                        c.client_lastname,
                                        c.contact,
                                        c.email_address,
                                        (
                                            SELECT COUNT(*) 
                                            FROM tbl_appoinment a 
                                            WHERE a.client_id = c.client_id AND a.attorney_id = $attorney_id
                                        ) AS total_appointments,
                                        (
                                            SELECT COUNT(*) 
                                            FROM tbl_case cs 
                                            WHERE cs.client_id = c.client_id AND cs.attorney_id = $attorney_id
                                        ) AS total_cases
                                    FROM tbl_client c
                                    JOIN tbl_appoinment a ON a.client_id = c.client_id
                                    WHERE a.attorney_id = $attorney_id
                                ";

                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $full_name = $row['client_firstname'] . ' ' . $row['client_middlename'] . ' ' . $row['client_lastname'];
                                    echo "<tr>
                                            <td>{$full_name}</td>
                                            <td>{$row['contact']}</td>
                                            <td>{$row['email_address']}</td>
                                            <td>{$row['total_appointments']}</td>
                                            <td>{$row['total_cases']}</td>
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
        $("#clientsTable").DataTable();
    });
</script>
</body>
</html>
