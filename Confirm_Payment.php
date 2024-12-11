// Example for confirm_payment.php (Confirm Payment)

<?php
include 'includes/header.php';
include 'includes/db.php';

$student_id = $_GET['student_id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    if ($amount >= 150000) {
        $query = "UPDATE students SET payment_status = 1 WHERE id = $student_id";
        mysqli_query($conn, $query);
        header('Location: index.php');
        exit;
    } else {
        $error = "Amount must be at least 150,000";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Confirm Payment</title>
</head>
<body>
    <div class="container">
        <h1>Confirm Payment</h1>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <label for="amount">Amount:</label>
            <input type="number" id="amount" name="amount" required>
            <button type="submit" class="btn">Confirm</button>
            <a href="payment_menu.php?student_id=<?php echo $student_id; ?>" class="btn">Back</a>
        </form>
    </div>
<?php include 'includes/footer.php'; ?>
</body>
</html>