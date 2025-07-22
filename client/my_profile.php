<?php
include 'includes/header.php';
include 'includes/connection.php';
session_start();

if (!isset($_SESSION['client_id'])) {
    header("Location: login.php");
    exit();
}

$client_id = $_SESSION['client_id'];

// Fetch client's profile details
$stmt = $conn->prepare("SELECT client_firstname, client_lastname, email_address, contact, valid_id FROM tbl_client WHERE client_id = ?");
$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();
$client = $result->fetch_assoc();

// Update profile logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_firstname = $_POST['client_firstname'];
    $client_lastname = $_POST['client_lastname'];
    $email_address = $_POST['email_address'];
    $contact = $_POST['contact'];
    $valid_id = $_POST['valid_id'];

    // Validate inputs (you can add more validations if necessary)
    if (empty($client_firstname) || empty($client_lastname) || empty($email_address) || empty($contact)) {
        $error = "Please fill in all fields.";
    } else {
        // Update client details in the database
        $update_stmt = $conn->prepare("UPDATE tbl_client SET client_firstname = ?, client_lastname = ?, email_address = ?, contact = ?, valid_id = ? WHERE client_id = ?");
        $update_stmt->bind_param("sssssi", $client_firstname, $client_lastname, $email_address, $contact, $valid_id, $client_id);
        
        if ($update_stmt->execute()) {
            $success = "Profile updated successfully!";
        } else {
            $error = "There was an error updating your profile.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
    <link rel="stylesheet" href="asset/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <?php include 'includes/topbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <div class="content-wrapper p-4">
        <h3>My Profile</h3>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="client_firstname">First Name</label>
                <input type="text" class="form-control" id="client_firstname" name="client_firstname" value="<?php echo htmlspecialchars($client['client_firstname']); ?>" required>
            </div>
            <div class="form-group">
                <label for="client_lastname">Last Name</label>
                <input type="text" class="form-control" id="client_lastname" name="client_lastname" value="<?php echo htmlspecialchars($client['client_lastname']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email_address">Email</label>
                <input type="email" class="form-control" id="email_address" name="email_address" value="<?php echo htmlspecialchars($client['email_address']); ?>" required>
            </div>
            <div class="form-group">
                <label for="contact">Phone Number</label>
                <input type="text" class="form-control" id="contact" name="contact" value="<?php echo htmlspecialchars($client['contact']); ?>" required>
            </div>
            <div class="form-group">
                <label for="valid_id">Valid ID</label>
                <textarea class="form-control" id="valid_id" name="valid_id" rows="3"><?php echo htmlspecialchars($client['valid_id']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>

    <?php include 'includes/footer.php'; ?>
</div>

</body>
</html>
