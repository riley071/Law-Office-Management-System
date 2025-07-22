<?php
session_start();
require_once "includes/connection.php"; // contains your DB connection

// Handle client login
if (isset($_POST['client_login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM tbl_client WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['client_id'] = $row['id'];
            $_SESSION['client_name'] = $row['name'];
            header("Location: client_dashboard.php");
            exit();
        } else {
            $_SESSION['login_error'] = "Incorrect password.";
            header("Location: client_login.php");
            exit();
        }
    } else {
        $_SESSION['login_error'] = "Username not found.";
        header("Location: client_login.php");
        exit();
    }
}
?>