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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
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

<style>

    /* General page styles */
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

.login-container {
    background-color: white;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    text-align: center;
}

/* Heading styling */
h1 {
    font-size: 28px;
    color: #243642; /* Primary color */
    margin-bottom: 20px;
    font-weight: bold;
}

/* Paragraph styling */
p {
    font-size: 16px;
    margin-bottom: 20px;
}

/* Error message styling */
.error {
    color: #ff4d4d;
    font-size: 14px;
    margin-top: 10px;
}

/* Form styling */
form {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
}

label {
    font-size: 16px;
    color: #243642;
    text-align: left;
    width: 100%;
}

/* Input fields */
input[type="text"],
input[type="password"] {
    font-size: 16px;
    padding: 12px;
    border-radius: 8px;
    width: 100%;
    border: 1px solid #ddd;
    margin-top: 5px;
}

input:focus {
    outline: none;
    border-color: #243642; /* Focus effect */
}

/* Button styling */
button.btn {
    background-color: #243642; /* Primary color */
    color: white;
    border: none;
    cursor: pointer;
    padding: 12px 25px;
    border-radius: 8px;
    font-size: 16px;
    transition: background-color 0.3s, transform 0.3s;
    margin-top: 20px;
}

button.btn:hover {
    background-color: #1a2b38; /* Darker shade on hover */
    transform: scale(1.05);
}

/* Responsive styles */
@media (max-width: 500px) {
    .login-container {
        width: 80%;
        padding: 30px;
    }

    h1 {
        font-size: 24px;
    }

    label,
    input[type="text"],
    input[type="password"],
    button.btn {
        font-size: 14px;
    }
}


</style>

</html>
