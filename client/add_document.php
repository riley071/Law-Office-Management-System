<?php
session_start();
include 'includes/connection.php';

// Ensure the client is logged in
if (!isset($_SESSION['client_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch client ID
$client_id = $_SESSION['client_id'];

// Fetch all cases of the client
$query = "SELECT case_id, case_title FROM tbl_case WHERE client_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $case_id = $_POST['case_id'];
    $file_name = $_FILES['document_file']['name'];
    $file_tmp = $_FILES['document_file']['tmp_name'];
    $file_path = '../uploads/documents/' . $file_name;

    // Move the uploaded file to the server's folder
    if (move_uploaded_file($file_tmp, $file_path)) {
        // Insert the document into the database
        $insert_query = "INSERT INTO tbl_documents (client_id, case_id, file_name, file_path, upload_date) VALUES (?, ?, ?, ?, NOW())";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("iiss", $client_id, $case_id, $file_name, $file_path);
        if ($insert_stmt->execute()) {
            $success_message = "Document uploaded successfully!";
        } else {
            $error_message = "Error uploading document!";
        }
    } else {
        $error_message = "Error moving the uploaded file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'includes/header.php'; ?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <?php include 'includes/topbar.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-primary"><i class="fa fa-upload"></i> Add Document</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="client_dashboard.php">Home</a></li>
                            <li class="breadcrumb-item active">Add Document</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-info">
                    <div class="card-body">
                        <?php if (isset($success_message)): ?>
                            <div class="alert alert-success"><?php echo $success_message; ?></div>
                        <?php elseif (isset($error_message)): ?>
                            <div class="alert alert-danger"><?php echo $error_message; ?></div>
                        <?php endif; ?>

                        <form method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="case_id">Select Case</label>
                                <select class="form-control" id="case_id" name="case_id" required>
                                    <option value="">Select Case</option>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <option value="<?php echo $row['case_id']; ?>"><?php echo $row['case_title']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="document_file">Upload Document</label>
                                <input type="file" class="form-control" id="document_file" name="document_file" accept=".pdf,.doc,.docx,.jpg,.png,.jpeg,.txt" required>
                            </div>
                            <button type="submit" class="btn btn-success">Upload Document</button>
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
