<?php
include 'includes/header.php'; 
include 'includes/connection.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $firm_name = mysqli_real_escape_string($conn, $_POST['firm_name']);
    $firm_address = mysqli_real_escape_string($conn, $_POST['firm_address']);
    $firm_contact = mysqli_real_escape_string($conn, $_POST['firm_contact']);
    $firm_email = mysqli_real_escape_string($conn, $_POST['firm_email']);
    $firm_history = mysqli_real_escape_string($conn, $_POST['firm_history']);

    // Insert into the tbl_firm table
    $insert_query = "INSERT INTO tbl_firm (firm_name, firm_address, firm_contact, firm_email, firm_history)
                     VALUES ('$firm_name', '$firm_address', '$firm_contact', '$firm_email', '$firm_history')";

    if (mysqli_query($conn, $insert_query)) {
        // Redirect to the office page after successful insertion
        header("Location: office.php?success=1");
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
                        <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-plus"></span> Add New Firm</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Add Firm</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Firm Details</h3>
                    </div>

                    <div class="card-body">
                        <?php if (isset($error_message)): ?>
                            <div class="alert alert-danger">
                                <?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="add-firm.php">
                            <div class="form-group">
                                <label for="firm_name">Firm Name</label>
                                <input type="text" id="firm_name" name="firm_name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="firm_address">Firm Address</label>
                                <textarea id="firm_address" name="firm_address" class="form-control" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="firm_contact">Firm Contact</label>
                                <input type="text" id="firm_contact" name="firm_contact" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="firm_email">Firm Email</label>
                                <input type="email" id="firm_email" name="firm_email" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="firm_history">Firm History</label>
                                <textarea id="firm_history" name="firm_history" class="form-control" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Add Firm</button>
                        </form>
                    </div>
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
