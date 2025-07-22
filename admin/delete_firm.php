<?php
include 'includes/connection.php';

// Check if firm ID is set
if (isset($_GET['id'])) {
    $firm_id = $_GET['id'];

    // Delete query
    $delete_query = "DELETE FROM tbl_firm WHERE firm_id = '$firm_id'";

    if (mysqli_query($conn, $delete_query)) {
        // Redirect to office page after successful deletion
        header("Location: office.php?success=2");
        exit();
    } else {
        // If there's an error
        $error_message = "Error: " . mysqli_error($conn);
    }
} else {
    // If no firm ID is provided
    header("Location: office.php");
    exit();
}
?>
