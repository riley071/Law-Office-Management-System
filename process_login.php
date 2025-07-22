<?php
session_start();
include "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    if (isset($_POST['admin_login'])) {
        $sql = "SELECT * FROM tbl_admin WHERE admin_user = '$username' AND admin_pass = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();
            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['admin_name'] = $admin['complete_name'];
            header("Location: admin/dashboard.php");
        } else {
            echo "Invalid admin login!";
        }

    } elseif (isset($_POST['attorney_login'])) {
        $sql = "SELECT * FROM tbl_attorney WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $attorney = $result->fetch_assoc();
            $_SESSION['attorney_id'] = $attorney['attorney_id'];
            $_SESSION['attorney_name'] = $attorney['first_name'] . ' ' . $attorney['last_name'];
            header("Location: attorney/index.php");
        } else {
            echo "Invalid attorney login!";
        }
    } else {
        echo "Login type not recognized.";
    }
}
?>
