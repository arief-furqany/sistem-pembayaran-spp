
<?php
include 'includes/header.php';
include 'includes/db.php';

$student_id = $_GET['student_id'];
$query = "SELECT * FROM students WHERE id = $student_id";
$result = mysqli_query($conn, $query);
$student = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Payment Menu</title>
</head>
<body>
    <div class="container">
        <h1>Payment Menu</h1>
        <p>Student: <?php echo $student['name']; ?></p>
        <p>Status: <?php echo $student['payment_status'] ? 'Paid' : 'Unpaid'; ?></p>
        <a href="confirm_payment.php?student_id=<?php echo $student_id; ?>" class="btn">Proceed to Payment</a>
    </div>
<?php include 'includes/footer.php'; ?>
</body>
</html>