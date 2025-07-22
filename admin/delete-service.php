<?php
// Assuming you're using a MySQL connection
include 'includes/connection.php'; // Include your database connection file

// Check if the service ID is passed
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $service_id = $_GET['id'];

    // Prepare the DELETE SQL query
    $delete_query = "DELETE FROM tbl_firm_services WHERE service_id = ?";

    // Initialize prepared statement
    if ($stmt = mysqli_prepare($conn, $delete_query)) {
        // Bind the service_id parameter to the query
        mysqli_stmt_bind_param($stmt, "i", $service_id);

        // Execute the query
        if (mysqli_stmt_execute($stmt)) {
            // Successfully deleted, redirect to services page
            header('Location: service.php?message=Service deleted successfully');
            exit;
        } else {
            // Error in deleting, show message
            echo "Error: Could not delete the service.";
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: Could not prepare query.";
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Redirect if service_id is not provided
    header('Location: service.php');
    exit;
}
?>
