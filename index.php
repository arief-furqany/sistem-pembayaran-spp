
<?php
include 'includes/header.php';
include 'includes/db.php';

$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : null;
if ($student_id) {
    $query = "SELECT * FROM students WHERE id = $student_id";
    $result = mysqli_query($conn, $query);
    $student = mysqli_fetch_assoc($result);
}

// Fetch all data for admin view
$query = "SELECT * FROM students";
$result_all = mysqli_query($conn, $query);
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
        <?php if ($student_id && $student): ?>
            <h2>Hello, <?php echo $student['name']; ?></h2>
        <?php endif; ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>NISN</th>
                    <th>Class</th>
                    <th>Payment Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result_all)): ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['nisn']; ?></td>
                        <td><?php echo $row['class']; ?></td>
                        <td><?php echo $row['payment_status'] ? 'Paid' : 'Unpaid'; ?></td>
                        <td>
                            <?php if (!$row['payment_status']): ?>
                                <a href="payment_menu.php?student_id=<?php echo $row['id']; ?>" class="btn">Pay</a>
                            <?php else: ?>
                                <span class="btn disabled">Paid</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php include 'includes/footer.php'; ?>
</body>
</html>
