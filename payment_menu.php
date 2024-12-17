<?php
include 'includes/header.php';
include 'includes/db.php';

// Mendapatkan ID siswa dari parameter URL
$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : null;

// Query untuk mendapatkan data siswa berdasarkan ID
$query = "SELECT * FROM students WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$stmt->close();

// Jika data siswa tidak ditemukan, tampilkan pesan kesalahan
if (!$student) {
    die("Student not found or invalid ID.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Payment Menu</title>
</head>
<body>
    <div class="container">
        <h1>Payment Menu</h1>
        <p><strong>Student:</strong> <?php echo htmlspecialchars($student['name']); ?></p>
        <p><strong>Status:</strong> <?php echo $student['payment_status'] ? 'Paid' : 'Unpaid'; ?></p>

        <?php if (!$student['payment_status']): ?>
            <form action="confirm_payment.php" method="GET">
                <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student['id']); ?>">

                <label for="payment_method"><strong>Pilih Metode Pembayaran:</strong></label><br>
                <select name="payment_method" id="payment_method" required>
                    <option value="">-- Pilih Metode Pembayaran --</option>
                    <option value="bank">Bank Transfer</option>
                    <option value="gopay">GoPay</option>
                </select><br><br>

                <button type="submit" class="btn">Lanjut ke pembayaran</button>
            </form>
        <?php else: ?>
            <p class="success">This student has already paid the SPP.</p>
        <?php endif; ?>
    </div>

    <?php include 'includes/footer.php'; ?>

    <style>

        /* General page styles */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f9f9f9;
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
    border-radius: 12px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 500px;
    text-align: center;
}

/* Heading style */
h1 {
    font-size: 28px;
    color: #243642; /* Primary color */
    margin-bottom: 20px;
    font-weight: bold;
}

/* Paragraph styling */
p {
    font-size: 18px;
    margin-bottom: 20px;
}

/* Form and input styles */
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

select, button {
    font-size: 16px;
    padding: 12px;
    border-radius: 8px;
    width: 100%;
    border: 1px solid #ddd;
}

select:focus, button:focus {
    outline: none;
    border-color: #243642; /* Focus effect */
}

/* Button styling */
button.btn {
    background-color: #243642; /* Primary color */
    color: white;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.3s;
}

button.btn:hover {
    background-color: #1a2b38; /* Darker shade on hover */
    transform: scale(1.05);
}

/* Success message styling */
.success {
    font-size: 18px;
    color: #28a745; /* Green color */
    margin-top: 20px;
}

/* Error message styling */
.error {
    color: #ff4d4d;
    font-size: 14px;
    margin-top: 10px;
}


    </style>
</body>
</html>
