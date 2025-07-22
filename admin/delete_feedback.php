<?php
include 'includes/connection.php';

if (isset($_POST['id'])) {
    $feedback_id = $_POST['id'];

    // Delete feedback query
    $delete_query = "DELETE FROM tbl_feedback WHERE feedback_id = '$feedback_id'";

    if (mysqli_query($conn, $delete_query)) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
