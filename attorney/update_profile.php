<?php
include 'includes/connection.php';
session_start();

if (!isset($_POST['attorney_id'])) {
    header("Location: profile.php");
    exit();
}

$attorney_id = $_POST['attorney_id'];
$contact = $_POST['contact_details'];
$email = $_POST['attorney_email'];
$address = $_POST['complete_address'];
$fax = $_POST['fax'];
$education = $_POST['education'];
$experience = $_POST['professional_experience'];
$username = $_POST['username'];
$password = $_POST['password'];

// Handle image upload
$profile_picture = '';
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
    $file_name = time() . "_" . basename($_FILES["profile_picture"]["name"]);
    $target_dir = "uploads/";
    $target_file = $target_dir . $file_name;
    move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file);
    $profile_picture = $file_name;
}

// Build SQL update query
$sql = "UPDATE tbl_attorney SET 
            contact_details=?, 
            attorney_email=?, 
            complete_address=?, 
            fax=?, 
            education=?, 
            professional_experience=?, 
            username=?";

$params = [$contact, $email, $address, $fax, $education, $experience, $username];
$types = "sssssss";

if (!empty($password)) {
    $sql .= ", password=?";
    $params[] = password_hash($password, PASSWORD_DEFAULT);
    $types .= "s";
}

if (!empty($profile_picture)) {
    $sql .= ", profile_picture=?";
    $params[] = $profile_picture;
    $types .= "s";
}

$sql .= " WHERE attorney_id=?";
$params[] = $attorney_id;
$types .= "i";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$stmt->close();

header("Location: profile.php?updated=1");
exit();
