<?php
include 'includes/header.php';
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($role === 'admin') {
        $query = "SELECT * FROM admin_users WHERE username = '$username' AND password = MD5('$password')";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            header('Location: admin_dashboard.php');
            exit;
        } else {
            $error = "Invalid admin credentials";
        }
    } elseif ($role === 'user') {
        $query = "SELECT * FROM students WHERE nisn = '$username'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $student = mysqli_fetch_assoc($result);
            header('Location: index.php?student_id=' . $student['id']);
            exit;
        } else {
            $error = "Invalid user credentials";
        }
    } else {
        $error = "Please select a role";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <label for="username">Username/NISN:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password (Admin only):</label>
            <input type="password" id="password" name="password">

            <label for="role">Login as:</label>
            <select id="role" name="role" required>
                <option value="">Select Role</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>

            <button type="submit" class="btn">Login</button>
        </form>
    </div>
<?php include 'includes/footer.php'; ?>
</body>
</html>

// Example for index.php (Landing Page)

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
