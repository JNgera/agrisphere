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

// Fetch feedback details
$sql = "SELECT d.*, u.name AS user_name, u.email
        FROM disputes d
        JOIN users u ON d.user_id = u.id
        WHERE d.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $feedback_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('Feedback not found!'); window.location='view_feedback.php';</script>";
    exit();
}
$feedback = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Details</title>
    <link rel="stylesheet" href="../assets/css/styles.css"> <!-- Adjust if necessary -->
</head>
<body>
    <?php include '../includes/admin_navbar.php'; ?>

    <div class="container">
        <h2>Feedback Details</h2>
        <p><strong>User:</strong> <?php echo htmlspecialchars($feedback['user_name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($feedback['email']); ?></p>
        <p><strong>Message:</strong> <?php echo nl2br(htmlspecialchars($feedback['message'])); ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($feedback['status']); ?></p>
        <p><strong>Date Submitted:</strong> <?php echo $feedback['created_at']; ?></p>
       
        <a href="view_feedback.php">Back to Feedback</a>
    </div>
</body>
</html>

