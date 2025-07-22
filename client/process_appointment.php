<?php
session_start();
include 'includes/connection.php';

// Check if the client is logged in
if (!isset($_SESSION['client_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $client_id = $_SESSION['client_id'];
    $service_id = $_POST['service_id'];
    $attorney_id = $_POST['attorney_id'];
    $appointment_date = $_POST['appointment_date'];
    $remarks = $_POST['remarks'];

    // Generate Reference Number
    $reference_number = "REF-" . rand(1000, 9999) . "-21";

    // Insert the appointment into tbl_appointment
    $query = "INSERT INTO tbl_appoinment (client_id, attorney_id, service_id, appointment_date, remarks, reference_number, status)
              VALUES ('$client_id', '$attorney_id', '$service_id', '$appointment_date', '$remarks', '$reference_number', 1)";
    
    if (mysqli_query($conn, $query)) {
        // Redirect to a confirmation page or show a success message
        echo "<script>alert('Appointment booked successfully!'); window.location.href = 'my_appointments.php';</script>";
    } else {
        echo "<script>alert('Error booking appointment. Please try again.'); window.location.href = 'client_appointments.php';</script>";
    }
}
?>
