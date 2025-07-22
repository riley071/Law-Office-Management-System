<?php
include 'includes/connection.php'; // Database connection

if (isset($_GET['id'])) {
    $client_id = $_GET['id'];

    // Delete client from the database
    $delete_query = "DELETE FROM tbl_client WHERE client_id = '$client_id'";

    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Client deleted successfully!'); window.location.href='clients.php';</script>";
    } else {
        echo "<script>alert('Error deleting client.'); window.location.href='clients.php';</script>";
    }
} else {
    echo "<script>window.location.href='clients.php';</script>";
}
?>
