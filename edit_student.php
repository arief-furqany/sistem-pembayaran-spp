<?php
include 'includes/header.php';
include 'includes/db.php';

// Get the student ID from the URL
$student_id = isset($_GET['student_id']) ? intval($_GET['student_id']) : null;

if ($student_id) {
    // Fetch the student's data
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
    $stmt->close();

    if (!$student) {
        echo "Student not found!";
        exit;
    }

    // Update payment status when the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $payment_status = isset($_POST['payment_status']) ? intval($_POST['payment_status']) : 0;

        $stmt = $conn->prepare("UPDATE students SET payment_status = ? WHERE id = ?");
        $stmt->bind_param("ii", $payment_status, $student_id);
        $stmt->execute();
        $stmt->close();

        // Redirect back to the dashboard
        header("Location: admin_dashboard.php");
        exit;
    }
} else {
    echo "Invalid request. Student ID is missing.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Payment Status</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Edit Payment Status</h1>
        <form method="POST">
            <div class="form-group">
                <label for="name">Name: </label>
                <strong><?php echo htmlspecialchars($student['name']); ?></strong>
            </div>
            <div class="form-group">
                <label for="nisn">NISN: </label>
                <strong><?php echo htmlspecialchars($student['nisn']); ?></strong>
            </div>
            <div class="form-group">
                <label for="class">Class: </label>
                <strong><?php echo htmlspecialchars($student['class']); ?></strong>
            </div>
            <div class="form-group">
                <label for="payment_status">Payment Status:</label>
                <select name="payment_status" id="payment_status" required>
                    <option value="0" <?php echo $student['payment_status'] == 0 ? 'selected' : ''; ?>>Unpaid</option>
                    <option value="1" <?php echo $student['payment_status'] == 1 ? 'selected' : ''; ?>>Paid</option>
                </select>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn">Update</button>
                <a href="admin_dashboard.php" class="btn cancel-btn">Cancel</a>
            </div>
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

/* Container for the form */
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

/* Form group styling */
.form-group {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    text-align: left;
}

label {
    font-size: 16px;
    color: #243642;
}

strong {
    font-weight: 600;
    color: #333;
}

/* Dropdown and select styling */
select {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid #ddd;
    font-size: 16px;
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
    padding: 12px 30px;
    border-radius: 8px;
    font-size: 16px;
    transition: background-color 0.3s, transform 0.3s;
    margin-top: 20px;
}

button.btn:hover {
    background-color: #1a2b38; /* Darker shade on hover */
    transform: scale(1.05);
}

/* Cancel button styling */
button.cancel-btn {
    background-color: #ddd;
    color: #333;
    margin-left: 10px;
}

button.cancel-btn:hover {
    background-color: #ccc;
}

/* Responsive styles */
@media (max-width: 500px) {
    .container {
        width: 90%;
        padding: 30px;
    }

    h1 {
        font-size: 24px;
    }

    label,
    select,
    button.btn {
        font-size: 14px;
    }
}


</style>
</html>
