<?php
include 'includes/header.php';
include 'includes/connection.php';

// Check if firm ID is set
if (isset($_GET['id'])) {
    $firm_id = $_GET['id'];

    // Get firm details
    $query = "SELECT * FROM tbl_firm WHERE firm_id = '$firm_id'";
    $result = mysqli_query($conn, $query);
    $firm = mysqli_fetch_assoc($result);

    // Get members of the firm
    $members_query = "SELECT * FROM tbl_attorney
                      JOIN tbl_attorney_firm ON tbl_attorney.attorney_id = tbl_attorney_firm.attorney_id
                      WHERE tbl_attorney_firm.firm_id = '$firm_id'";
    $members_result = mysqli_query($conn, $members_query);
} else {
    header("Location: office.php");
    exit();
}
?>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <?php include 'includes/topbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-eye"></span> View Firm Details</h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo $firm['firm_name']; ?> Details</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Firm Name:</strong> <?php echo $firm['firm_name']; ?></p>
                        <p><strong>Firm Address:</strong> <?php echo $firm['firm_address']; ?></p>
                        <p><strong>Contact:</strong> <?php echo $firm['firm_contact']; ?></p>
                        <p><strong>Email:</strong> <?php echo $firm['firm_email']; ?></p>
                        <p><strong>Firm History:</strong> <?php echo $firm['firm_history']; ?></p>

                        <h4>Firm Members</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Attorney Name</th>
                                    <th>Contact</th>
                                    <th>Email</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($member = mysqli_fetch_assoc($members_result)): ?>
                                    <tr>
                                        <td><?php echo $member['attorney_name']; ?></td>
                                        <td><?php echo $member['attorney_contact']; ?></td>
                                        <td><?php echo $member['attorney_email']; ?></td>
                                        <td class="text-right">
                                            <a class="btn btn-sm btn-info" href="view-attorney.php?id=<?php echo $member['attorney_id']; ?>"><i class="fa fa-eye"></i> View</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
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
</body>
</html>
