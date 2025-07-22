<?php
include 'includes/header.php';
include 'includes/connection.php'; 
?>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <?php include 'includes/topbar.php'?>
    <?php include 'includes/sidebar.php'?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-landmark"></span> Law Office Firms</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Office</li>
                        </ol>
                    </div>
                    <a class="btn btn-sm elevation-2" href="add-firm.php" style="margin-top: 20px;margin-left: 10px;background-color: #05445E;color: #ddd;"><i
                        class="fa fa-plus"></i>
                        Add New</a>
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
                                    <th>Firm Name</th>
                                    <th>Address</th>
                                    <th>Contact</th>
                                    <th>Email</th>
                                    <th>Firm History</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Get the list of law firms from the database
                                $query = "SELECT * FROM tbl_firm"; // Assuming the table for firm information is `tbl_firm`
                                $result = mysqli_query($conn, $query);

                                // Loop through each firm and display details
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $firm_id = $row['firm_id'];
                                    $firm_name = $row['firm_name'];
                                    $firm_address = $row['firm_address'];
                                    $firm_contact = $row['firm_contact'];
                                    $firm_email = $row['firm_email'];
                                    $firm_history = $row['firm_history'];
                                    
                                    ?>

                                <tr>
                                    <td><?= $firm_name ?></td>
                                    <td><?= $firm_address ?></td>
                                    <td><?= $firm_contact ?></td>
                                    <td><?= $firm_email ?></td>
                                    <td><?= $firm_history ?></td>
                                    <td class="text-right">
                                        <a class="btn btn-sm btn-info" href="view_firm.php?firm_id=<?= $firm_id ?>"><i class="fa fa-eye"></i> View firm</a>
                                        <a class="btn btn-sm btn-success" href="edit_firm.php?firm_id=<?= $firm_id ?>"><i class="fa fa-edit"></i> Edit</a>
                                        <a class="btn btn-sm btn-danger" href="delete_firm.php?firm_id=<?= $firm_id ?>" data-toggle="modal" data-target="#delete"><i class="fa fa-trash-alt"></i> Delete</a>
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



<!-- jQuery -->
<script src="../asset/jquery/jquery.min.js"></script>
<script src="../asset/js/bootstrap.bundle.min.js"></script>
<script src="../asset/js/adminlte.js"></script>
<!-- DataTables  & Plugins -->
<script src="../asset/tables/datatables/jquery.dataTables.min.js"></script>
<script src="../asset/tables/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../asset/tables/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../asset/tables/datatables-buttons/js/buttons.bootstrap4.min.js"></script>

</body>
</html>
