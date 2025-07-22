<?php
include 'includes/header.php';
include 'includes/connection.php';
session_start();

if (!isset($_SESSION['client_id'])) {
    header("Location: login.php");
    exit();
}

$client_id = $_SESSION['client_id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_feedback'])) {
    $attorney_id = $_POST['attorney_id'];
    $rate = $_POST['rate'];
    $message = trim($_POST['message']);

    // Check for duplicate feedback
    $check = $conn->prepare("SELECT * FROM tbl_feedback WHERE client_id = ? AND attorney_id = ?");
    $check->bind_param("ii", $client_id, $attorney_id);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows == 0) {
        $insert = $conn->prepare("INSERT INTO tbl_feedback (client_id, attorney_id, message, rate, status) VALUES (?, ?, ?, ?, 1)");
        $insert->bind_param("iisi", $client_id, $attorney_id, $message, $rate);
        $insert->execute();
        $feedback_msg = "Feedback submitted!";
    } else {
        $feedback_msg = "You already submitted feedback for this attorney.";
    }
}

// Fetch confirmed appointments
$stmt = $conn->prepare("SELECT a.attorney_id, a.appointment_date, f.service_name,
                        CONCAT(at.first_name, ' ', at.last_name) AS attorney_name
                        FROM tbl_appoinment a
                        LEFT JOIN tbl_attorney at ON a.attorney_id = at.attorney_id
                        LEFT JOIN tbl_firm_services f ON a.service_id = f.service_id
                        WHERE a.client_id = ? AND a.status = 2
                        ORDER BY a.appointment_date DESC");

$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();

// Debugging: Print number of rows returned
echo "<pre>Rows found: " . $result->num_rows . "</pre>";

// Check if any error occurred during the query execution
if ($stmt->error) {
    echo "SQL Error: " . $stmt->error;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Give Feedback</title>
    <link rel="stylesheet" href="asset/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <?php include 'includes/topbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <div class="content-wrapper p-4">
        <h3>Submit Feedback</h3>

        <?php if (isset($feedback_msg)): ?>
            <div class="alert alert-info"><?php echo $feedback_msg; ?></div>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <strong><?php echo htmlspecialchars($row['attorney_name']); ?></strong> – <?php echo $row['service_name']; ?>
                        <span class="float-right"><?php echo date("F j, Y", strtotime($row['appointment_date'])); ?></span>
                    </div>
                    <div class="card-body">
                        <form action="client_feedback.php" method="post">
                            <input type="hidden" name="attorney_id" value="<?php echo $row['attorney_id']; ?>">

                            <div class="form-group">
                                <label>Rate (1–5):</label>
                                <select name="rate" class="form-control" required>
                                    <option value="">Select Rating</option>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?> Star<?php echo $i > 1 ? 's' : ''; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Feedback Message:</label>
                                <textarea name="message" class="form-control" rows="3" required></textarea>
                            </div>

                            <button type="submit" name="submit_feedback" class="btn btn-primary">Submit Feedback</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-warning">No confirmed appointments found. Please book an appointment first.</div>
        <?php endif; ?>
    </div>

    <?php include 'includes/footer.php'; ?>
</div>
</body>
</html>
