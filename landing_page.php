<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include "includes/header.php"?>

<div class="login-container">
    <div class="user-login">
        <button><a href="login_user.php">Login siswa</a></button>
    </div>
    <div class="admin-login">
        <button><a href="login_admin.php">Login admin</a></button>
    </div>
</div>

<?php include "includes/footer.php" ?>

</body>
</html>
<style>

/* General page styles */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #e9ecef;
    margin: 0;
    padding: 0;
}

/* Link styling */
a {
    text-decoration: none;
    color: inherit;
}

/* Primary color */
:root {
    --primary-color: #243642;
}

/* Layout for the login options */
.login-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    align-items: center;
    height: 100vh;
    padding: 0 40px;
}

/* Common style for login sections */
.user-login, .admin-login {
    text-align: center;
    padding: 20px;
    background-color: white;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

/* Hover effect for login sections */
.user-login:hover, .admin-login:hover {
    transform: translateY(-10px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}

/* Button styling */
button {
    background-color: var(--primary-color);
    color: white;
    font-size: 18px;
    padding: 16px 32px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.3s;
    width: 100%;
}

button:hover {
    background-color: #1a2b38;
    transform: scale(1.05);
}

button a {
    color: white;
    display: block;
    width: 100%;
}


</style>