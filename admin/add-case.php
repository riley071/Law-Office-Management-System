<?php
include 'includes/header.php'; 
include 'includes/connection.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id = mysqli_real_escape_string($conn, $_POST['client_id']);
    $attorney_id = mysqli_real_escape_string($conn, $_POST['attorney_id']);
    $case_title = mysqli_real_escape_string($conn, $_POST['case_title']);
    $case_description = mysqli_real_escape_string($conn, $_POST['case_description']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $created_at = date('Y-m-d H:i:s');

    $insert_query = "INSERT INTO tbl_case (client_id, attorney_id, case_title, case_description, status, created_at)
                     VALUES ('$client_id', '$attorney_id', '$case_title', '$case_description', '$status', '$created_at')";

    if (mysqli_query($conn, $insert_query)) {
        header("Location: case_progress.php?success=1");
        exit();
    } else {
        $error_message = "Error: " . mysqli_error($conn);
    }
}
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
                        <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-briefcase"></span> Add New Case</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Add Case</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Case Details</h3>
                    </div>

                    <div class="card-body">
                        <?php if (isset($error_message)): ?>
                            <div class="alert alert-danger">
                                <?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="add-case.php">
                            <!-- Client Dropdown -->
                            <div class="form-group">
                                <label for="client_id">Client</label>
                                <select name="client_id" class="form-control" required>
                                    <option value="">Select Client</option>
                                    <?php
                                    $clients = mysqli_query($conn, "SELECT client_id, client_firstname, client_lastname FROM tbl_client");
                                    while ($row = mysqli_fetch_assoc($clients)) {
                                        echo "<option value='{$row['client_id']}'>{$row['client_firstname']} {$row['client_lastname']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Attorney Dropdown -->
                            <div class="form-group">
                                <label for="attorney_id">Attorney</label>
                                <select name="attorney_id" class="form-control" required>
                                    <option value="">Select Attorney</option>
                                    <?php
                                    $attorneys = mysqli_query($conn, "SELECT attorney_id, first_name, last_name FROM tbl_attorney");
                                    while ($row = mysqli_fetch_assoc($attorneys)) {
                                        echo "<option value='{$row['attorney_id']}'>{$row['first_name']} {$row['last_name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Case Title -->
                            <div class="form-group">
                                <label for="case_title">Case Title</label>
                                <input type="text" name="case_title" class="form-control" required>
                            </div>

                            <!-- Case Description -->
                            <div class="form-group">
                                <label for="case_description">Case Description</label>
                                <textarea name="case_description" class="form-control" rows="4" required></textarea>
                            </div>

                            <!-- Status -->
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="Open">Open</option>
                                    <option value="Closed">Closed</option>
                                    <option value="Pending">Pending</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Add Case</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<script src="../asset/jquery/jquery.min.js"></script>
<script src="../asset/js/bootstrap.bundle.min.js"></script>
<script src="../asset/js/adminlte.js"></script>
</body>
</html>
