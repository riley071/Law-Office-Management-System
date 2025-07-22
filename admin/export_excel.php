<?php
include 'includes/connection.php';

$year = $_GET['year'] ?? date('Y');

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Appointments_$year.xls");

echo "Month\tAppointments\n";

$query = "SELECT MONTH(appointment_date) AS month, COUNT(*) AS count 
          FROM tbl_appoinment 
          WHERE YEAR(appointment_date) = '$year' 
          GROUP BY MONTH(appointment_date)";
$result = mysqli_query($conn, $query);

$months = [ "January", "February", "March", "April", "May", "June", 
            "July", "August", "September", "October", "November", "December" ];
$data = array_fill(0, 12, 0);

while ($row = mysqli_fetch_assoc($result)) {
    $data[(int)$row['month'] - 1] = $row['count'];
}

for ($i = 0; $i < 12; $i++) {
    echo "{$months[$i]}\t{$data[$i]}\n";
}
?>
