<?php
include 'includes/connection.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lastname = mysqli_real_escape_string($conn, $_POST['client_lastname']);
    $firstname = mysqli_real_escape_string($conn, $_POST['client_firstname']);
    $middlename = mysqli_real_escape_string($conn, $_POST['client_middlename']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $email = mysqli_real_escape_string($conn, $_POST['email_address']);
    $valid_id = mysqli_real_escape_string($conn, $_POST['valid_id']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $status = mysqli_real_escape_string($conn, $_POST['account_status']);

    $query = "INSERT INTO tbl_client (
        client_lastname,
        client_firstname,
        client_middlename,
        contact,
        email_address,
        valid_id,
        username,
        password,
        account_status
    ) VALUES (
        '$lastname',
        '$firstname',
        '$middlename',
        '$contact',
        '$email',
        '$valid_id',
        '$username',
        '$password',
        '$status'
    )";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Client added successfully!'); window.location.href='client.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
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

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="m-0" style="color: rgb(31,108,163);">
                    <i class="fa fa-user-plus"></i> Add New Client
                </h1>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-info">
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Last Name</label>
                                    <input type="text" name="client_lastname" class="form-control" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>First Name</label>
                                    <input type="text" name="client_firstname" class="form-control" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Middle Name</label>
                                    <input type="text" name="client_middlename" class="form-control" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Contact</label>
                                    <input type="text" name="contact" class="form-control" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Email Address</label>
                                    <input type="email" name="email_address" class="form-control" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Valid ID</label>
                                    <input type="text" name="valid_id" class="form-control" required placeholder="e.g. National ID, Passport No.">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Username</label>
                                    <input type="text" name="username" class="form-control" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Account Status</label>
                                    <select name="account_status" class="form-control" required>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Client</button>
                            <a href="view-clients.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back</a>
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
