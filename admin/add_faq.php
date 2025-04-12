<?php
session_start();
include '../config/db.php';; // Ensure this path is correct

// Check if admin is logged in
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    echo "<script>alert('Unauthorized access!'); window.location='../../auth/login.php';</script>";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question = $_POST['question'];
    $answer = $_POST['answer'];

    $query = "INSERT INTO faqs (question, answer) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $question, $answer);

    if ($stmt->execute()) {
        echo "<script>alert('FAQ added successfully!'); window.location='manage_faqs.php';</script>";
    } else {
        echo "<script>alert('Error adding FAQ.');</script>";
    }
}
?>
<link rel="stylesheet" href="../assets/css/styles.css"> <!-- Adjust if necessary -->
<?php include "../includes/admin_navbar.php"; ?> <!-- Adjust the path as necessary -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add FAQ</title>
</head>
<body>

    <h2>Add New FAQ</h2>

    <form method="POST">
        <label>Question:</label><br>
        <input type="text" name="question" required><br><br>
       
        <label>Answer:</label><br>
        <textarea name="answer" required></textarea><br><br>
       
        <button type="submit">Add FAQ</button>
    </form>

</body>
</html>