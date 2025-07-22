<!-- appointment_delete.php -->

<?php
include 'includes/connection.php';

$appointment_id = $_GET['id'];

$delete_query = "DELETE FROM tbl_appoinment WHERE appointment_id = '$appointment_id'";
if (mysqli_query($conn, $delete_query)) {
   echo "<script>alert('Appointment deleted successfully!'); window.location.href='appointment.php';</script>";
} else {
   echo "<script>alert('Error deleting appointment.'); window.location.href='appointment.php';</script>";
}
?>
