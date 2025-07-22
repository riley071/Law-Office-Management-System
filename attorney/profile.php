<?php
include 'includes/header.php';
include 'includes/connection.php';
session_start();

if (!isset($_SESSION['attorney_id'])) {
    header("Location: login.php");
    exit();
}

$attorney_id = $_SESSION['attorney_id'];
$sql = "SELECT * FROM tbl_attorney WHERE attorney_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $attorney_id);
$stmt->execute();
$result = $stmt->get_result();
$attorney = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <?php include 'includes/topbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="m-0" style="color: rgb(31,108,163);"><i class="fa fa-user"></i> Profile</h1>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                    <div class="card card-info">
                        <div class="card-body">
                            <input type="hidden" name="attorney_id" value="<?= $attorney['attorney_id'] ?>">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Full Name</label>
                                    <input type="text" class="form-control" value="<?= $attorney['first_name'] . ' ' . $attorney['middle_name'] . ' ' . $attorney['last_name'] ?>" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label>Contact</label>
                                    <input type="text" name="contact_details" class="form-control" value="<?= $attorney['contact_details'] ?>">
                                </div>
                                <div class="col-md-4">
                                    <label>Email</label>
                                    <input type="email" name="attorney_email" class="form-control" value="<?= $attorney['attorney_email'] ?>">
                                </div>
                                <div class="col-md-12">
                                    <label>Address</label>
                                    <input type="text" name="complete_address" class="form-control" value="<?= $attorney['complete_address'] ?>">
                                </div>
                                <div class="col-md-4">
                                    <label>Fax</label>
                                    <input type="text" name="fax" class="form-control" value="<?= $attorney['fax'] ?>">
                                </div>
                                <div class="col-md-4">
                                    <label>Education</label>
                                    <input type="text" name="education" class="form-control" value="<?= $attorney['education'] ?>">
                                </div>
                                <div class="col-md-4">
                                    <label>Profile Picture</label>
                                    <input type="file" name="profile_picture" class="form-control">
                                    <?php if ($attorney['profile_picture']): ?>
                                        <img src="uploads/<?= $attorney['profile_picture'] ?>" width="100" height="100" class="mt-2">
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-12">
                                    <label>Professional & Legal Experience</label>
                                    <textarea name="professional_experience" class="form-control"><?= $attorney['professional_experience'] ?></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label>Username</label>
                                    <input type="text" name="username" class="form-control" value="<?= $attorney['username'] ?>">
                                </div>
                                <div class="col-md-6">
                                    <label>Password (leave blank to keep current)</label>
                                    <input type="password" name="password" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <?php include 'includes/footer.php'; ?>
</div>
</body>
</html>
