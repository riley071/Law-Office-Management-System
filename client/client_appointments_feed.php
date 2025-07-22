<?php
include 'includes/connection.php';
session_start();

// Check if the client is logged in
if (!isset($_SESSION['client_id'])) {
    echo json_encode([]); // If not logged in, return empty array
    exit();
}

$client_id = $_SESSION['client_id'];

// Fetch appointments for the client
$stmt = $conn->prepare("SELECT appointment_date, reference_number FROM tbl_appoinment WHERE client_id = ? AND status != 0");
$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();

// Prepare events for the calendar
$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = [
        'title' => 'Appointment: ' . $row['reference_number'],
        'start' => $row['appointment_date']
    ];
}

echo json_encode($events);
?>
