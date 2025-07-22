<?php
include 'includes/connection.php'; // Database connection

// Check if the admin is logged in and fetch their data
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

$admin_id = $_SESSION['admin_id'];

// Fetch current admin details
$query = "SELECT * FROM tbl_admin WHERE admin_id = '$admin_id'";
$result = mysqli_query($conn, $query);
$admin = mysqli_fetch_assoc($result);

// Handle form submission for updating details or password
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_details'])) {
        // Update admin details (except password)
        $complete_name = $_POST['complete_name'];
        $email_address = $_POST['email_address'];

        $update_query = "UPDATE tbl_admin SET complete_name = '$complete_name', email_address = '$email_address' WHERE admin_id = '$admin_id'";

        if (mysqli_query($conn, $update_query)) {
            echo "<script>alert('Admin details updated successfully!');</script>";
        } else {
            echo "<script>alert('Error updating details.');</script>";
        }
    }

    if (isset($_POST['change_password'])) {
        // Change password
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Check if current password is correct
        if (password_verify($current_password, $admin['admin_pass'])) {
            if ($new_password == $confirm_password) {
                // Hash the new password and update
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_pass_query = "UPDATE tbl_admin SET admin_pass = '$hashed_password' WHERE admin_id = '$admin_id'";

                if (mysqli_query($conn, $update_pass_query)) {
                    echo "<script>alert('Password updated successfully!');</script>";
                } else {
                    echo "<script>alert('Error updating password.');</script>";
                }
            } else {
                echo "<script>alert('New password and confirm password do not match.');</script>";
            }
        } else {
            echo "<script>alert('Current password is incorrect.');</script>";
        }
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
                            <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-user"></span> Admin Profile</h1>
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
                                <h4>Admin Details</h4>
                                <div class="form-group">
                                    <label for="complete_name">Complete Name</label>
                                    <input type="text" class="form-control" name="complete_name" value="<?php echo $admin['complete_name']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="email_address">Email Address</label>
                                    <input type="email" class="form-control" name="email_address" value="<?php echo $admin['email_address']; ?>" required>
                                </div>
                                <button type="submit" name="update_details" class="btn btn-primary">Update Details</button>
                            </form>

                            <hr>

                            <h4>Change Password</h4>
                            <form method="POST">
                                <div class="form-group">
                                    <label for="current_password">Current Password</label>
                                    <input type="password" class="form-control" name="current_password" required>
                                </div>
                                <div class="form-group">
                                    <label for="new_password">New Password</label>
                                    <input type="password" class="form-control" name="new_password" required>
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password">Confirm New Password</label>
                                    <input type="password" class="form-control" name="confirm_password" required>
                                </div>
                                <button type="submit" name="change_password" class="btn btn-danger">Change Password</button>
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
