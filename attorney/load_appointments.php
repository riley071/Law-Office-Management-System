<?php
session_start();
if (!isset($_SESSION['attorney_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

include 'includes/connection.php';
$attorney_id = $_SESSION['attorney_id'];

$query = "
    SELECT 
        a.reference_number,
        a.appointment_date,
        a.status,
        c.client_firstname,
        c.client_middlename,
        c.client_lastname,
        s.service_name
    FROM tbl_appoinment a
    JOIN tbl_client c ON a.client_id = c.client_id
    JOIN tbl_firm_services s ON a.service_id = s.service_id
    WHERE a.attorney_id = $attorney_id
";

$result = mysqli_query($conn, $query);

$appointments = [];

$status_map = [
    1 => 'Pending',
    2 => 'Approved',
    3 => 'Completed',
    4 => 'Cancelled'
];

while ($row = mysqli_fetch_assoc($result)) {
    $appointments[] = [
        'title' => $row['service_name'],
        'start' => $row['appointment_date'],
        'client' => $row['client_firstname'] . ' ' . $row['client_middlename'] . ' ' . $row['client_lastname'],
        'service' => $row['service_name'],
        'status' => $status_map[$row['status']] ?? 'Unknown'
    ];
}

header('Content-Type: application/json');
echo json_encode($appointments);
