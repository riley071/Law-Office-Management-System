<?php
include 'includes/connection.php'; // Database connection

if (isset($_GET['id'])) {
    $client_id = $_GET['id'];
    $query = "SELECT * FROM tbl_client WHERE client_id = '$client_id'";
    $result = mysqli_query($conn, $query);
    $client = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update client details
    $client_firstname = $_POST['client_firstname'];
    $client_middlename = $_POST['client_middlename'];
    $client_lastname = $_POST['client_lastname'];
    $contact = $_POST['contact'];
    $email_address = $_POST['email_address'];
    $account_status = $_POST['account_status'];

    $update_query = "UPDATE tbl_client SET 
                     client_firstname = '$client_firstname', 
                     client_middlename = '$client_middlename', 
                     client_lastname = '$client_lastname', 
                     contact = '$contact', 
                     email_address = '$email_address', 
                     account_status = '$account_status' 
                     WHERE client_id = '$client_id'";

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Client updated successfully!'); window.location.href='client.php';</script>";
    } else {
        echo "<script>alert('Error updating client.');</script>";
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
                            <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-users"></span> Edit Client</h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="card card-info">
                        <div class="card-body">
                            <form method="POST">
                                <div class="form-group">
                                    <label for="client_firstname">First Name</label>
                                    <input type="text" class="form-control" name="client_firstname" value="<?php echo $client['client_firstname']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="client_middlename">Middle Name</label>
                                    <input type="text" class="form-control" name="client_middlename" value="<?php echo $client['client_middlename']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="client_lastname">Last Name</label>
                                    <input type="text" class="form-control" name="client_lastname" value="<?php echo $client['client_lastname']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="contact">Contact</label>
                                    <input type="text" class="form-control" name="contact" value="<?php echo $client['contact']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="email_address">Email</label>
                                    <input type="email" class="form-control" name="email_address" value="<?php echo $client['email_address']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="account_status">Status</label>
                                    <select name="account_status" class="form-control" required>
                                        <option value="1" <?php if ($client['account_status'] == 1) echo 'selected'; ?>>Active</option>
                                        <option value="0" <?php if ($client['account_status'] == 0) echo 'selected'; ?>>Inactive</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Client</button>
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
