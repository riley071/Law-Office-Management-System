<?php
include 'includes/connection.php';

// Check if the ID is passed
if (isset($_GET['id'])) {
    $attorney_id = $_GET['id'];

    // Fetch existing attorney data
    $query = "SELECT * FROM tbl_attorney WHERE attorney_id = '$attorney_id'";
    $result = mysqli_query($conn, $query);
    $attorney = mysqli_fetch_assoc($result);

    if (!$attorney) {
        header("Location: attorney-list.php?error=Attorney not found");
        exit;
    }
}

// Update attorney details if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $complete_address = mysqli_real_escape_string($conn, $_POST['complete_address']);
    $contact_details = mysqli_real_escape_string($conn, $_POST['contact_details']);
    $fax = mysqli_real_escape_string($conn, $_POST['fax']);
    $profile_picture = mysqli_real_escape_string($conn, $_POST['profile_picture']);
    $education = mysqli_real_escape_string($conn, $_POST['education']);
    $professional_experience = mysqli_real_escape_string($conn, $_POST['professional_experience']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $account_status = mysqli_real_escape_string($conn, $_POST['account_status']);

    // Update query
    $update_query = "UPDATE tbl_attorney SET first_name='$first_name', last_name='$last_name', middle_name='$middle_name', 
                    gender='$gender', complete_address='$complete_address', contact_details='$contact_details', 
                    fax='$fax', profile_picture='$profile_picture', education='$education', 
                    professional_experience='$professional_experience', username='$username', password='$password', 
                    account_status='$account_status' WHERE attorney_id='$attorney_id'";

    // Execute the query
    if (mysqli_query($conn, $update_query)) {
        header("Location: attorney-list.php?message=Attorney updated successfully");
        exit;
    } else {
        $error_message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'includes/header.php' ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include 'includes/topbar.php' ?>
        <?php include 'includes/sidebar.php' ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-user-edit"></span> Edit Attorney</h1>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Edit Attorney Information</h3>
                        </div>
                        <div class="card-body">
                            <?php if (isset($error_message)) { echo '<div class="alert alert-danger">' . $error_message . '</div>'; } ?>
                            <form method="POST" action="edit-attorney.php?id=<?php echo $attorney['attorney_id']; ?>" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $attorney['first_name']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $attorney['last_name']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="middle_name">Middle Name</label>
                                    <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?php echo $attorney['middle_name']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select class="form-control" id="gender" name="gender" required>
                                        <option value="1" <?php if ($attorney['gender'] == 1) echo 'selected'; ?>>Male</option>
                                        <option value="2" <?php if ($attorney['gender'] == 2) echo 'selected'; ?>>Female</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="complete_address">Complete Address</label>
                                    <input type="text" class="form-control" id="complete_address" name="complete_address" value="<?php echo $attorney['complete_address']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="contact_details">Contact Details</label>
                                    <input type="text" class="form-control" id="contact_details" name="contact_details" value="<?php echo $attorney['contact_details']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="fax">Fax</label>
                                    <input type="text" class="form-control" id="fax" name="fax" value="<?php echo $attorney['fax']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="profile_picture">Profile Picture</label>
                                    <input type="file" class="form-control" id="profile_picture" name="profile_picture" value="<?php echo $attorney['profile_picture']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="education">Education</label>
                                    <textarea class="form-control" id="education" name="education" required><?php echo $attorney['education']; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="professional_experience">Professional Experience</label>
                                    <textarea class="form-control" id="professional_experience" name="professional_experience" required><?php echo $attorney['professional_experience']; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $attorney['username']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" value="<?php echo $attorney['password']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="account_status">Account Status</label>
                                    <select class="form-control" id="account_status" name="account_status" required>
                                        <option value="1" <?php if ($attorney['account_status'] == 1) echo 'selected'; ?>>Active</option>
                                        <option value="0" <?php if ($attorney['account_status'] == 0) echo 'selected'; ?>>Inactive</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Update Attorney</button>
                                </div>
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
