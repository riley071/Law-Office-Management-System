<?php 
include 'includes/header.php'; 
include 'includes/connection.php'; 
?>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<?php include 'includes/topbar.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="content-wrapper">
<div class="content-header">
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-chart-bar"></span> Reports</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Reports</li>
            </ol>
        </div>
    </div>
</div>
</div>

<?php
// Get available years from database
$years = [];
$year_query = "SELECT DISTINCT YEAR(appointment_date) AS year FROM tbl_appoinment ORDER BY year DESC";
$year_result = mysqli_query($conn, $year_query);
while ($row = mysqli_fetch_assoc($year_result)) {
    $years[] = $row['year'];
}

// Default to current year or selected year
$selectedYear = $_GET['year'] ?? date('Y');

// Get appointment count per month for selected year
$months = [ "January", "February", "March", "April", "May", "June", 
            "July", "August", "September", "October", "November", "December" ];
$appointmentsPerMonth = array_fill(0, 12, 0);

$query = "SELECT MONTH(appointment_date) AS month, COUNT(*) AS count 
          FROM tbl_appoinment 
          WHERE YEAR(appointment_date) = '$selectedYear'
          GROUP BY MONTH(appointment_date)";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $appointmentsPerMonth[(int)$row['month'] - 1] = $row['count'];
}
?>

<section class="content">
<div class="container-fluid">
    <form method="get" class="mb-3">
        <label for="year">Filter by Year:</label>
        <select name="year" onchange="this.form.submit()">
            <?php foreach ($years as $year): ?>
                <option value="<?= $year ?>" <?= ($year == $selectedYear) ? 'selected' : '' ?>><?= $year ?></option>
            <?php endforeach; ?>
        </select>
        <a href="export_excel.php?year=<?= $selectedYear ?>" class="btn btn-success btn-sm ml-2">Export to Excel</a>
    </form>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Appointments</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 0; $i < 12; $i++): ?>
                                <tr>
                                    <td><?= $months[$i] ?></td>
                                    <td><?= $appointmentsPerMonth[$i] ?></td>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <canvas id="bargraph"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
</div>
</div>

<script src="../asset/jquery/jquery.min.js"></script>
<script src="../asset/js/adminlte.js"></script>
<script src="../asset/js/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const labels = <?= json_encode($months); ?>;
    const data = <?= json_encode($appointmentsPerMonth); ?>;

    const ctx = document.getElementById('bargraph').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Appointments in <?= $selectedYear ?>',
                data: data,
                backgroundColor: 'rgb(79,129,189)',
                borderColor: 'rgba(0, 158, 251, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
});
</script>
</body>
</html>
