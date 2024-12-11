/*
This document provides the structure for a Student SPP Payment system. 
Each page is implemented in a separate PHP file, and the CSS provides a simple, elegant design.
The following code demonstrates the core components of this system.
*/

// Directory Structure
// - index.php (Landing Page)
// - payment_menu.php (Payment Menu)
// - confirm_payment.php (Confirm Payment)
// - admin_dashboard.php (Admin Dashboard)
// - edit_student.php (Edit Student Data)
// - includes/
//     - header.php (Header Template)
//     - footer.php (Footer Template)
//     - db.php (Database Connection)

// Example for index.php (Landing Page)

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
        <h1>Welcome to SPP Payment System</h1>
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
                            <a href="payment_menu.php?student_id=<?php echo $row['id']; ?>" class="btn">Pay</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php include 'includes/footer.php'; ?>
</body>
</html>





// Include templates (header.php, footer.php, db.php)
// Add corresponding admin pages: admin_dashboard.php, edit_student.php.
