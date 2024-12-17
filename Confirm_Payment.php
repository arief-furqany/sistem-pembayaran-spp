<?php
include 'includes/header.php';
include 'includes/db.php';

// Mendapatkan parameter dari URL
$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : null;
$payment_method = isset($_GET['payment_method']) ? $_GET['payment_method'] : null;

// Validasi parameter
if (!$student_id || !$payment_method) {
    die("Invalid request. Missing parameters.");
}

// Query untuk mendapatkan data siswa
$query = "SELECT * FROM students WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$stmt->close();

// Jika siswa tidak ditemukan
if (!$student) {
    die("Student not found.");
}

// Jumlah bulan maksimal yang dapat dibayar (misal dari awal tahun ajaran, anggap 12 bulan total)
$total_months = 12;
$paid_months = $student['payment_status'] ? $total_months : 0; // Contoh asumsi `payment_status` menentukan bulan yang dibayar
$remaining_months = $total_months - $paid_months;

// Jika form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $months_to_pay = isset($_POST['months_to_pay']) ? intval($_POST['months_to_pay']) : 0;

    // Validasi input jumlah bulan
    if ($months_to_pay < 1 || $months_to_pay > $remaining_months) {
        $error = "Invalid number of months selected.";
    } else {
        // Hitung total pembayaran
        $total_payment = $months_to_pay * 150000;

        // Update status pembayaran siswa di database
        $stmt = $conn->prepare("UPDATE students SET payment_status = 1 WHERE id = ?");
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $stmt->close();

        // Tampilkan pesan sukses
        $success = "Pembayaran sebanyak Rp " . number_format($total_payment, 0, ',', '.') . " untuk $months_to_pay Telah berhasil diproses.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Confirm Payment</title>
</head>
<body>
    <div class="container">
        <h1>Confirm Payment</h1>
        <p><strong>Student:</strong> <?php echo htmlspecialchars($student['name']); ?></p>
        <p><strong>NISN:</strong> <?php echo htmlspecialchars($student['nisn']); ?></p>
        <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($payment_method); ?></p>
        <p><strong>Status:</strong> <?php echo $student['payment_status'] ? 'Paid' : 'Unpaid'; ?></p>

        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>

        <?php if (!$student['payment_status']): ?>
            <form method="POST">
                <label for="months_to_pay">Select Months to Pay:</label>
                <select id="months_to_pay" name="months_to_pay" required>
                    <option value="">-- Select --</option>
                    <?php for ($i = 1; $i <= $remaining_months; $i++): ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?> Month(s) - Rp <?php echo number_format($i * 150000, 0, ',', '.'); ?></option>
                    <?php endfor; ?>
                </select><br><br>

                <button type="submit" class="btn">Confirm Payment</button>
                <a href="payment_menu.php?student_id=<?php echo $student_id; ?>" class="btn back-btn">Back</a>
            </form>
        <?php else: ?>
            <p class="success">Semua SPP telah dibayar.</p>
        <?php endif; ?>
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

.container {
    background-color: white;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 500px;
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
    font-size: 18px;
    margin-bottom: 20px;
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

/* Select input */
select {
    font-size: 16px;
    padding: 12px;
    border-radius: 8px;
    width: 100%;
    border: 1px solid #ddd;
}

select:focus {
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
}

button.btn:hover {
    background-color: #1a2b38; /* Darker shade on hover */
    transform: scale(1.05);
}

/* Back button styling */
a.back-btn {
    text-decoration: none;
    background-color: #ddd;
    color: #243642;
    padding: 12px 25px;
    border-radius: 8px;
    font-size: 16px;
    transition: background-color 0.3s;
}

a.back-btn:hover {
    background-color: #b0b0b0;
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

</html>
