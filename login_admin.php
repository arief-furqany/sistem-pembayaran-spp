<?php
include 'includes/header.php';
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM admin_users WHERE username = '$username' AND password = MD5('$password')";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        header('Location: admin_dashboard.php');
        exit;
    } else {
        $error = "Admin Kredensial Tidak Valid";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Admin Login</title>
</head>
<body>
    <div class="container">
        <h1>Admin Login</h1>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <label for="username">Username: </label>
            <input type="text" id="username" name="username" required> <br>

            <label for="password">Password: </label>
            <input type="password" id="password" name="password" required> <br>

            <button type="submit" class="btn">Login</button>
        </form>
    </div>
<?php include 'includes/footer.php'; ?>
</body>
</html>
