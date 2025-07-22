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
                        <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-calendar-alt"></span> Appointments</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Appointments</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-info">
                    <div class="col-md-12 table-responsive"><br>
                        <table id="example1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Ref No.</th>
                                    <th>Customer</th>
                                    <th>Contact</th>
                                    <th>Email</th>
                                    <th>Service Name</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "
                                    SELECT 
                                        a.reference_number,
                                        a.remarks,
                                        a.status,
                                        a.appointment_date,
                                        c.client_firstname,
                                        c.client_middlename,
                                        c.client_lastname,
                                        c.email_address,
                                        c.contact,
                                        s.service_name
                                    FROM tbl_appoinment a
                                    JOIN tbl_client c ON a.client_id = c.client_id
                                    JOIN tbl_firm_services s ON a.service_id = s.service_id
                                    WHERE a.attorney_id = $attorney_id
                                    ORDER BY a.appointment_date DESC
                                ";

                                $result = mysqli_query($conn, $query);

                                while ($row = mysqli_fetch_assoc($result)) {
                                    $ref_no = $row['reference_number'];
                                    $full_name = $row['client_firstname'] . ' ' . $row['client_middlename'] . ' ' . $row['client_lastname'];
                                    $contact = $row['contact'];
                                    $email = $row['email_address'];
                                    $service_name = $row['service_name'];
                                    $appointment_date = $row['appointment_date'];

                                    switch ($row['status']) {
                                        case 1:
                                            $status_badge = "<span class='badge bg-info'>pending</span>";
                                            break;
                                        case 2:
                                            $status_badge = "<span class='badge bg-warning'>approved</span>";
                                            break;
                                        case 3:
                                            $status_badge = "<span class='badge bg-success'>completed</span>";
                                            break;
                                        case 4:
                                            $status_badge = "<span class='badge bg-danger'>cancelled</span>";
                                            break;
                                        default:
                                            $status_badge = "<span class='badge bg-secondary'>unknown</span>";
                                    }

                                    echo "<tr>
                                            <td>{$ref_no}</td>
                                            <td>{$full_name}</td>
                                            <td>{$contact}</td>
                                            <td>{$email}</td>
                                            <td>{$service_name}</td>
                                            <td>{$appointment_date}</td>
                                            <td>{$status_badge}</td>
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
        $("#example1").DataTable();
    });
</script>
</body>
</html>
