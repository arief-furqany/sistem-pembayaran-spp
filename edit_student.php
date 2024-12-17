<?php
include 'includes/header.php';
include 'includes/db.php';

// Get the student ID from the URL
$student_id = isset($_GET['student_id']) ? intval($_GET['student_id']) : null;

if ($student_id) {
    // Fetch the student's data
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
    $stmt->close();

    if (!$student) {
        echo "Student not found!";
        exit;
    }

    // Update payment status when the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $payment_status = isset($_POST['payment_status']) ? intval($_POST['payment_status']) : 0;

        $stmt = $conn->prepare("UPDATE students SET payment_status = ? WHERE id = ?");
        $stmt->bind_param("ii", $payment_status, $student_id);
        $stmt->execute();
        $stmt->close();

        // Redirect back to the dashboard
        header("Location: admin_dashboard.php");
        exit;
    }
} else {
    echo "Invalid request. Student ID is missing.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Edit Student Payment Status</title>
</head>
<body>
    <div class="container">
        <h1>Edit Payment Status</h1>
        <form method="POST">
            <p>
                <label>Name: </label>
                <strong><?php echo htmlspecialchars($student['name']); ?></strong>
            </p>
            <p>
                <label>NISN: </label>
                <strong><?php echo htmlspecialchars($student['nisn']); ?></strong>
            </p>
            <p>
                <label>Class: </label>
                <strong><?php echo htmlspecialchars($student['class']); ?></strong>
            </p>
            <p>
                <label>Payment Status:</label>
                <select name="payment_status">
                    <option value="0" <?php echo $student['payment_status'] == 0 ? 'selected' : ''; ?>>Unpaid</option>
                    <option value="1" <?php echo $student['payment_status'] == 1 ? 'selected' : ''; ?>>Paid</option>
                </select>
            </p>
            <button type="submit" class="btn">Update</button>
            <a href="admin_dashboard.php" class="btn">Cancel</a>
        </form>
    </div>
<?php include 'includes/footer.php'; ?>
</body>
</html>
