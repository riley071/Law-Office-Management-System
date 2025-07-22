<?php
require_once "includes/connection.php"; // Update this path if needed

if (isset($_POST['register_client'])) {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $email = mysqli_real_escape_string($conn, $_POST['email_address']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // secure hashing

    // Check if username or email already exists
    $check = mysqli_query($conn, "SELECT * FROM tbl_client WHERE username = '$username' OR email_address = '$email'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Username or Email already exists'); window.location.href='client_register.php';</script>";
        exit();
    }

    // Insert data into tbl_client with correct column names
    $insert = "INSERT INTO tbl_client (client_firstname, client_middlename, client_lastname, contact, email_address, username, password) 
               VALUES ('$first_name', '$middle_name', '$last_name', '$contact', '$email', '$username', '$password')";
    if (mysqli_query($conn, $insert)) {
        echo "<script>alert('Registration successful. Please login.'); window.location.href='client_login.php';</script>";
    } else {
        echo "<script>alert('Error: Registration failed.'); window.location.href='client_register.php';</script>";
    }
}
?>
