<?php
include 'includes/header.php';
include 'includes/db.php';

// Fetch data from the database
$query = "SELECT * FROM students";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>SPP Payment System</title>
</head>
<body>
    <div class="container">
        <h1>Selamat Datang di Sistem Pembayaran SPP</h1>
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
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['nisn']; ?></td>
                        <td><?php echo $row['class']; ?></td>
                        <td><?php echo $row['payment_status'] ? 'Paid' : 'Unpaid'; ?></td>
                        <td>
                            <a href="payment_menu.php?student_id=<?php echo $row['id']; ?>" class="btn">Bayar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php include 'includes/footer.php'; ?>
</body>
</html>
