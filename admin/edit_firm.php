<?php
include 'includes/header.php';
include 'includes/connection.php';

// Check if firm ID is set
if (isset($_GET['id'])) {
    $firm_id = $_GET['id'];

    // Get the current firm details
    $query = "SELECT * FROM tbl_firm WHERE firm_id = '$firm_id'";
    $result = mysqli_query($conn, $query);
    $firm = mysqli_fetch_assoc($result);

    // Update the firm if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $firm_name = mysqli_real_escape_string($conn, $_POST['firm_name']);
        $firm_address = mysqli_real_escape_string($conn, $_POST['firm_address']);
        $firm_contact = mysqli_real_escape_string($conn, $_POST['firm_contact']);
        $firm_email = mysqli_real_escape_string($conn, $_POST['firm_email']);
        $firm_history = mysqli_real_escape_string($conn, $_POST['firm_history']);

        // Update query
        $update_query = "UPDATE tbl_firm 
                         SET firm_name = '$firm_name', firm_address = '$firm_address', 
                             firm_contact = '$firm_contact', firm_email = '$firm_email', 
                             firm_history = '$firm_history' 
                         WHERE firm_id = '$firm_id'";

        if (mysqli_query($conn, $update_query)) {
            // Redirect to the office page after successful update
            header("Location: office.php?success=3");
            exit();
        } else {
            $error_message = "Error: " . mysqli_error($conn);
        }
    }
} else {
    header("Location: office.php");
    exit();
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
                        <h1 class="m-0" style="color: rgb(31,108,163);"><span class="fa fa-edit"></span> Edit Firm</h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Edit Firm Details</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error_message)): ?>
                            <div class="alert alert-danger">
                                <?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="edit-firm.php?id=<?php echo $firm['firm_id']; ?>">
                            <div class="form-group">
                                <label for="firm_name">Firm Name</label>
                                <input type="text" id="firm_name" name="firm_name" class="form-control" value="<?php echo $firm['firm_name']; ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="firm_address">Firm Address</label>
                                <textarea id="firm_address" name="firm_address" class="form-control" required><?php echo $firm['firm_address']; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="firm_contact">Firm Contact</label>
                                <input type="text" id="firm_contact" name="firm_contact" class="form-control" value="<?php echo $firm['firm_contact']; ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="firm_email">Firm Email</label>
                                <input type="email" id="firm_email" name="firm_email" class="form-control" value="<?php echo $firm['firm_email']; ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="firm_history">Firm History</label>
                                <textarea id="firm_history" name="firm_history" class="form-control" required><?php echo $firm['firm_history']; ?></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Firm</button>
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
