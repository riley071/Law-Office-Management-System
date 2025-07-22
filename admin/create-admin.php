<?php
include 'includes/connection.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_user = $_POST['admin_user'];
    $admin_pass = $_POST['admin_pass'];
    $complete_name = $_POST['complete_name'];
    $email_address = $_POST['email_address'];

    // Hash the password
    $hashed_password = password_hash($admin_pass, PASSWORD_DEFAULT);

    // Insert the new admin
    $insert_query = "INSERT INTO tbl_admin (admin_user, admin_pass, complete_name, email_address) 
                     VALUES ('$admin_user', '$hashed_password', '$complete_name', '$email_address')";

    if (mysqli_query($conn, $insert_query)) {
        echo "<script>alert('New admin created successfully!'); window.location.href='admin-list.php';</script>";
    } else {
        echo "<script>alert('Error creating new admin.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'includes/header.php'; ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include 'includes/topbar.php'; ?>
        <?php include 'includes/sidebar.php'; ?>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-user-plus"></span> Create New Admin</h1>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-info">
                        <div class="card-body">
                            <form method="POST">
                                <div class="form-group">
                                    <label for="admin_user">Username</label>
                                    <input type="text" class="form-control" name="admin_user" required>
                                </div>
                                <div class="form-group">
                                    <label for="admin_pass">Password</label>
                                    <input type="password" class="form-control" name="admin_pass" required>
                                </div>
                                <div class="form-group">
                                    <label for="complete_name">Complete Name</label>
                                    <input type="text" class="form-control" name="complete_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="email_address">Email Address</label>
                                    <input type="email" class="form-control" name="email_address" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Create Admin</button>
                            </form>
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
