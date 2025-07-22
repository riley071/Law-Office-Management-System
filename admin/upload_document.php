<?php
include 'includes/connection.php';

$case_id = $_POST['case_id'];
$description = $_POST['description'];
$uploaded_by = $_POST['uploaded_by'];

// Organize uploads in folders by case ID
$target_dir = "uploads/documents/case_" . $case_id . "/";

// Create the directory if it doesn't exist
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$file_name = basename($_FILES["document"]["name"]);
$unique_name = time() . "_" . $file_name;
$target_file = $target_dir . $unique_name;

if (move_uploaded_file($_FILES["document"]["tmp_name"], $target_file)) {
    $stmt = $conn->prepare("INSERT INTO tbl_documents (case_id, uploaded_by, file_name, file_path, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $case_id, $uploaded_by, $file_name, $target_file, $description);
    $stmt->execute();
    header("Location: view_documents.php?msg=success");
    exit();
} else {
    echo "Sorry, there was an error uploading your file.";
}
?>
