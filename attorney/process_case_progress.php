<?php
include 'includes/connection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $case_id = $_POST['case_id'];
    $update_title = $_POST['update_title'];
    $update_description = $_POST['update_description'];
    $update_date = $_POST['update_date'];

    // Insert progress into tbl_case_progress
    $query = "INSERT INTO tbl_case_progress (case_id, update_title, update_description, update_date) 
              VALUES (?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "isss", $case_id, $update_title, $update_description, $update_date);
        
        // Execute the query
        if (mysqli_stmt_execute($stmt)) {
            // Redirect back to the case progress tracker page
            header("Location: case.php");
            exit;
        } else {
            echo "Error saving progress: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing query: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
