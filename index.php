<?php
include 'includes/header.php';
include 'includes/db.php';

define('SPP_PER_MONTH', 150000); // Tarif SPP per bulan

// Get the student ID from the URL
$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : null;
$student = null;

if ($student_id) {
    // Use prepared statement to prevent SQL Injection
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
    $stmt->close();

    // Calculate the amount of unpaid SPP
    $unpaid_spp = !$student['payment_status'] ? SPP_PER_MONTH : 0;
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>SPP Payment System</title>
</head>
<body>
    <div class="container">
        <h1>Welcome to SPP Payment System</h1>
        <?php if ($student): ?>
            <h2>Hello, <?php echo htmlspecialchars($student['name']); ?></h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>NISN</th>
                        <th>Class</th>
                        <th>Payment Status</th>
                        <th>Unpaid Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo htmlspecialchars($student['name']); ?></td>
                        <td><?php echo htmlspecialchars($student['nisn']); ?></td>
                        <td><?php echo htmlspecialchars($student['class']); ?></td>
                        <td><?php echo $student['payment_status'] ? 'Paid' : 'Unpaid'; ?></td>
                        <td>Rp. <?php echo number_format($unpaid_spp, 0, ',', '.'); ?></td>
                        <td>
                            <?php if (!$student['payment_status']): ?>
                                <a href="payment_menu.php?student_id=<?php echo $student['id']; ?>" class="btn">Pay</a>
                            <?php else: ?>
                                <span class="btn disabled">Paid</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <p class="error">No student data found or you are not logged in.</p>
        <?php endif; ?>
    </div>
<?php include 'includes/footer.php'; ?>
</body>
</html>
