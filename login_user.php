<?php
include 'includes/header.php';
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nisn = $_POST['nisn'];
    $password = $_POST['password'];

    // Use prepared statement to prevent SQL Injection
    $stmt = $conn->prepare("SELECT * FROM students WHERE nisn = ? AND password = MD5(?)");
    $stmt->bind_param("ss", $nisn, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
        // Redirect to student dashboard or specific page
        header('Location: index.php?student_id=' . $student['id']);
        exit;
    } else {
        $error = "Invalid NISN or password.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Student Login</title>
</head>
<body>
    <div class="container">
        <h1>Student Login</h1>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <label for="nisn">NISN: </label>
            <input type="text" id="nisn" name="nisn" required> <br>

            <label for="password">Password: </label>
            <input type="password" id="password" name="password" required> <br>

            <button type="submit" class="btn">Login</button>
        </form>
    </div>
<?php include 'includes/footer.php'; ?>
</body>
</html>
