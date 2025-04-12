<?php
session_start();
include '../config/db.php';

// Check if admin is logged in
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    echo "<script>alert('Unauthorized access!'); window.location='../../auth/login.php';</script>";
    exit();
}

if (!isset($_GET['id'])) {
    echo "<script>alert('Invalid request!'); window.location='view_feedback.php';</script>";
    exit();
}

$feedback_id = intval($_GET['id']);

// Handle status update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_status = $_POST['status'];
    $sql = "UPDATE disputes SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_status, $feedback_id);

    if ($stmt->execute()) {
        echo "<script>alert('Feedback status updated!'); window.location='view_feedback.php';</script>";
    } else {
        echo "<script>alert('Error updating status.');</script>";
    }
}

// Fetch current status
$sql = "SELECT status FROM disputes WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $feedback_id);
$stmt->execute();
$result = $stmt->get_result();
$feedback = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Feedback Status</title>
    <link rel="stylesheet" href="../assets/css/styles.css"> <!-- Adjust if necessary -->
</head>
<body>
    <?php include '../includes/admin_navbar.php'; ?>

    <div class="container">
        <h2>Update Feedback Status</h2>
        <form method="post">
            <label for="status">Status:</label>
            <select name="status" required>
                <option value=" Pending" <?php if ($feedback['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                <option value="Resolved" <?php if ($feedback['status'] == 'Resolved') echo 'selected'; ?>>Resolved</option>
            </select>
            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>