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

<style>
/* General body and container styles */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    color: #333;
}

.container {
    background-color: white;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    text-align: center;
}

/* Heading style */
h1 {
    font-size: 24px;
    color: #243642; /* Primary color */
    margin-bottom: 20px;
}

/* Form styling */
form {
    display: flex;
    flex-direction: column;
}

label {
    font-size: 16px;
    margin-bottom: 5px;
    text-align: left;
}

input {
    padding: 10px;
    font-size: 16px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    width: 100%;
}

input:focus {
    border-color: #243642; /* Primary color */
    outline: none;
}

/* Button styling */
button.btn {
    background-color: #243642; /* Primary color */
    color: white;
    font-size: 16px;
    padding: 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button.btn:hover {
    background-color: #1a2b38; /* Darker shade on hover */
}

/* Error message styling */
.error {
    color: #ff4d4d;
    font-size: 14px;
    margin-bottom: 15px;
}

</style>
</body>
</html>
