<?php
include 'includes/connection.php'; // Database connection

// Fetch all clients from the database
$query = "SELECT client_id, client_firstname, client_middlename, client_lastname, contact, email_address, account_status FROM tbl_client";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'includes/header.php' ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include 'includes/topbar.php' ?>
        <?php include 'includes/sidebar.php' ?>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0" style="color: rgb(31,108,163);">
                                <span class="fa fa-users"></span> List of Clients
                            </h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Clients</li>
                            </ol>
                        </div>
                        <a class="btn btn-sm elevation-2" href="add-client.php" style="margin-top: 20px;margin-left: 10px;background-color: #05445E;color: #ddd;">
                            <i class="fa fa-user-plus"></i> Add New
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-info">
                        <div class="col-md-12 table-responsive">
                            <br>
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Profile</th>
                                        <th>Full Name</th>
                                        <th>Contact</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($client = mysqli_fetch_assoc($result)) { ?>
                                    <tr>
                                        <td><img src="../asset/img/avatar.png" width="50" alt="User Image"></td>
                                        <td><?php echo $client['client_firstname'] . " " . $client['client_middlename'] . " " . $client['client_lastname']; ?></td>
                                        <td><?php echo $client['contact']; ?></td>
                                        <td><?php echo $client['email_address']; ?></td>
                                        <td>
                                            <?php echo $client['account_status'] == 1 ? "<span class='badge badge-success'>Active</span>" : "<span class='badge badge-secondary'>Inactive</span>"; ?>
                                        </td>
                                        <td class="text-right">
                                            <a class="btn btn-sm btn-success" href="edit-client.php?id=<?php echo $client['client_id']; ?>"><i class="fa fa-edit"></i> Edit</a>
                                            <a class="btn btn-sm btn-danger" href="delete-client.php?id=<?php echo $client['client_id']; ?>" onclick="return confirm('Are you sure you want to delete this client?')"><i class="fa fa-trash-alt"></i> Delete</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
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
    <script src="../asset/tables/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../asset/tables/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script>
        $(function () {
            $("#example1").DataTable();
        });
    </script>
</body>

</html>
