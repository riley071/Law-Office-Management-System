<?php
include 'includes/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $case_id = $_POST['case_id'];
    $status = $_POST['status'];
    $update_title = $_POST['update_title'];
    $update_description = $_POST['update_description'];
    $update_date = $_POST['update_date'];

    // Prepare update query
    $query = "UPDATE tbl_case_progress 
              SET update_title = ?, update_description = ?, update_date = ? 
              WHERE case_id = ?";

    if ($stmt = mysqli_prepare($conn, $query)) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "sssi", $update_title, $update_description, $update_date, $case_id);

        // Execute the update query
        if (mysqli_stmt_execute($stmt)) {
            // Redirect back to the case progress tracker page after successful update
            header("Location: case_progress.php");
            exit;
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing query: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
