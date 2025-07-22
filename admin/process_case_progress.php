<?php
include 'includes/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from the form
    $client_id = $_POST['client_id'];
    $attorney_id = $_POST['attorney_id'];
    $case_title = $_POST['case_title'];
    $status = $_POST['status'];
    $case_description = $_POST['case_description'];

    // Insert new case
    $query = "INSERT INTO tbl_case (client_id, attorney_id, case_title, status, case_description, created_at) 
              VALUES (?, ?, ?, ?, ?, NOW())";

    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "iisss", $client_id, $attorney_id, $case_title, $status, $case_description);

        if (mysqli_stmt_execute($stmt)) {
            // Redirect or show success
            header("Location: cases.php?message=Case+created+successfully");
            exit;
        } else {
            echo "Error inserting case: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing query: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
