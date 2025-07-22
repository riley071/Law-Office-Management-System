<?php
include 'includes/header.php';
include 'includes/connection.php';
session_start();

if (isset($_SESSION['client_id'])) {
    header("Location: client_dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and fetch the input values
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Query the database to verify the credentials
    $stmt = $conn->prepare("SELECT client_id, password FROM tbl_client WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($client_id, $hashed_password);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Start session and set client_id
            $_SESSION['client_id'] = $client_id;
            header("Location: client_dashboard.php");
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "User not found.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client Login</title>
    <link rel="stylesheet" href="asset/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="asset/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h3>Client Login</h3>
            </div>
            <div class="card-body">
                <?php if (isset($error)) { echo '<div class="alert alert-danger">' . $error . '</div>'; } ?>
                <form action="client_login.php" method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="username" placeholder="Username" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-user-tag"></span></div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-lock"></span></div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
                <p class="mt-3 mb-0 text-center">
                    <a href="client_register.php">Register as New Client</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
