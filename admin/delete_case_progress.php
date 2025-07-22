<?php
include 'includes/connection.php';

// Check if the 'id' parameter is passed
if (isset($_GET['id'])) {
    $case_id = $_GET['id'];

    // Prepare the DELETE query
    $query = "DELETE FROM tbl_case_progress WHERE case_id = ?";
    
    // Prepare statement
    if ($stmt = mysqli_prepare($conn, $query)) {
        // Bind the parameter
        mysqli_stmt_bind_param($stmt, "i", $case_id);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // If the query was successful, redirect to the case progress page
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing query: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}

// Close the database connection
mysqli_close($conn);
?>
