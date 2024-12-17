<?php
include 'includes/header.php';
include 'includes/db.php';

$query = "SELECT * FROM students";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>NISN</th>
                    <th>Kelas</th>
                    <th>Status Pembayaran</th>
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
                            <a href="edit_student.php?student_id=<?php echo $row['id']; ?>" class="btn">edit data</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php include 'includes/footer.php'; ?>
</body>
</html>
