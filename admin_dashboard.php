<?php
include 'includes/header.php';
include 'includes/db.php';

// Initialize filters
$class_filter = isset($_GET['class']) ? $_GET['class'] : '';
$payment_status_filter = isset($_GET['payment_status']) ? $_GET['payment_status'] : '';
$name_filter = isset($_GET['name']) ? $_GET['name'] : '';

// Prepare the query based on filters
$query = "SELECT * FROM students WHERE 1";

if ($class_filter) {
    $query .= " AND class = '" . mysqli_real_escape_string($conn, $class_filter) . "'";
}

if ($payment_status_filter !== '') {
    $query .= " AND payment_status = " . mysqli_real_escape_string($conn, $payment_status_filter);
}

if ($name_filter) {
    $query .= " AND name LIKE '%" . mysqli_real_escape_string($conn, $name_filter) . "%'";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>

        <!-- Filter Form -->
        <form method="GET" class="filter-form">
            <div class="filter-group">
                <label for="class">Class:</label>
                <select name="class" id="class">
                    <option value="">-- All Classes --</option>
                    <option value="Class A" <?php echo $class_filter == 'Class A' ? 'selected' : ''; ?>>Class A</option>
                    <option value="Class B" <?php echo $class_filter == 'Class B' ? 'selected' : ''; ?>>Class B</option>
                    <option value="Class C" <?php echo $class_filter == 'Class C' ? 'selected' : ''; ?>>Class C</option>
                    <!-- Add more classes as needed -->
                </select>
            </div>
            <div class="filter-group">
                <label for="payment_status">Payment Status:</label>
                <select name="payment_status" id="payment_status">
                    <option value="">-- All Status --</option>
                    <option value="1" <?php echo $payment_status_filter == '1' ? 'selected' : ''; ?>>Paid</option>
                    <option value="0" <?php echo $payment_status_filter == '0' ? 'selected' : ''; ?>>Unpaid</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($name_filter); ?>" placeholder="Search by name">
            </div>
            <button type="submit" class="btn">Filter</button>
        </form>

        <!-- Student Data Table -->
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
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['nisn']; ?></td>
                        <td><?php echo $row['class']; ?></td>
                        <td><?php echo $row['payment_status'] ? 'Paid' : 'Unpaid'; ?></td>
                        <td>
                            <a href="edit_student.php?student_id=<?php echo $row['id']; ?>" class="btn">Edit Data</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>

<style>

                    /* Filter Form Styles */
.filter-form {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
    gap: 15px;
    background-color: #f9f9f9;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.filter-group {
    flex: 1;
}

.filter-group label {
    font-size: 16px;
    color: #243642;
}

.filter-group select,
.filter-group input {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border-radius: 5px;
    border: 1px solid #ddd;
}

.filter-group select:focus,
.filter-group input:focus {
    outline: none;
    border-color: #243642; /* Primary color */
}

button.btn {
    background-color: #243642; /* Primary color */
    color: white;
    padding: 12px 25px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
}

button.btn:hover {
    background-color: #1a2b38;
    transform: scale(1.05);
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #243642;
    color: white;
}

td {
    background-color: #f9f9f9;
}

td a {
    background-color: #243642;
    color: white;
    padding: 8px 15px;
    border-radius: 5px;
    text-decoration: none;
}

td a:hover {
    background-color: #1a2b38;
}


</style>
</html>
