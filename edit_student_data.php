// Example for edit_student.php (Edit Student Data)

<?php
include 'includes/header.php';
include 'includes/db.php';

$student_id = $_GET['student_id'];
$query = "SELECT * FROM students WHERE id = $student_id";
$result = mysqli_query($conn, $query);
$student = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $nisn = $_POST['nisn'];
    $class = $_POST['class'];
    $payment_status = isset($_POST['payment_status']) ? 1 : 0;

    $update_query = "UPDATE students SET name = '$name', nisn = '$nisn', class = '$class', payment_status = $payment_status WHERE id = $student_id";
    mysqli_query($conn, $update_query);
    header('Location: admin_dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Edit Student</title>
</head>
<body>
    <div class="container">
        <h1>Edit Student Data</h1>
        <form method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $student['name']; ?>" required>
            <label for="nisn">NISN:</label>
            <input type="text" id="nisn" name="nisn" value="<?php echo $student['nisn']; ?>" required>
            <label for="class">Class:</label>
            <input type="text" id="class" name="class" value="<?php echo $student['class']; ?>" required>
            <label for="payment_status">Payment Status:</label>
            <input type="checkbox" id="payment_status" name="payment_status" <?php echo $student['payment_status'] ? 'checked' : ''; ?>>
            <button type="submit" class="btn">Save</button>
        </form>
    </div>
<?php include 'includes/footer.php'; ?>
</body>
</html>
