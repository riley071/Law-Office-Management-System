<?php
include 'includes/connection.php';

// Check if the form is submitted
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
    $attorney_email = mysqli_real_escape_string($conn, $_POST['attorney_email']);  // Added the email field

    // Insert query
    $insert_query = "INSERT INTO tbl_attorney (first_name, last_name, middle_name, gender, complete_address, contact_details, 
                    fax, profile_picture, education, professional_experience, username, password, account_status, attorney_email) 
                    VALUES ('$first_name', '$last_name', '$middle_name', '$gender', '$complete_address', '$contact_details', 
                            '$fax', '$profile_picture', '$education', '$professional_experience', '$username', '$password', '$account_status', '$attorney_email')";

    // Execute the query
    if (mysqli_query($conn, $insert_query)) {
        header("Location: attorney.php?message=Attorney added successfully");
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
                            <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-user-plus"></span> Add Attorney</h1>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Enter Attorney Information</h3>
                        </div>
                        <div class="card-body">
                            <?php if (isset($error_message)) { echo '<div class="alert alert-danger">' . $error_message . '</div>'; } ?>
                            <form method="POST" action="add-attorney.php" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="first_name">First Name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="middle_name">Middle Name</label>
                                        <input type="text" class="form-control" id="middle_name" name="middle_name">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="gender">Gender</label>
                                        <select class="form-control" id="gender" name="gender" required>
                                            <option value="1">Male</option>
                                            <option value="2">Female</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="complete_address">Complete Address</label>
                                        <input type="text" class="form-control" id="complete_address" name="complete_address" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="contact_details">Contact Details</label>
                                        <input type="text" class="form-control" id="contact_details" name="contact_details" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="fax">Fax</label>
                                        <input type="text" class="form-control" id="fax" name="fax" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="profile_picture">Profile Picture</label>
                                        <input type="file" class="form-control" id="profile_picture" name="profile_picture" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="education">Education</label>
                                        <textarea class="form-control" id="education" name="education" required></textarea>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="professional_experience">Professional Experience</label>
                                        <textarea class="form-control" id="professional_experience" name="professional_experience" required></textarea>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="account_status">Account Status</label>
                                        <select class="form-control" id="account_status" name="account_status" required>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="attorney_email">Email Address</label>
                                        <input type="email" class="form-control" id="attorney_email" name="attorney_email" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Add Attorney</button>
                                <a href="attorney.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back</a>
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
