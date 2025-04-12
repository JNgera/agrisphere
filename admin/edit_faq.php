<?php
session_start();
include '../config/db.php';; // Ensure this path is correct

// Check if admin is logged in
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    echo "<script>alert('Unauthorized access!'); window.location='../../auth/login.php';</script>";
    exit();
}

// Get FAQ ID
if (!isset($_GET['id'])) {
    echo "<script>alert('Invalid request.'); window.location='manage_faqs.php';</script>";
    exit();
}

$faq_id = intval($_GET['id']);

// Fetch existing FAQ
$query = "SELECT * FROM faqs WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $faq_id);
$stmt->execute();
$result = $stmt->get_result();
$faq = $result->fetch_assoc();

if (!$faq) {
    echo "<script>alert('FAQ not found.'); window.location='manage_faqs.php';</script>";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question = $_POST['question'];
    $answer = $_POST['answer'];
    $query = "UPDATE faqs SET question = ?, answer = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $question, $answer, $faq_id);

    if ($stmt->execute()) {
        echo "<script>alert('FAQ updated successfully!'); window.location='manage_faqs.php';</script>";
    } else {
        echo "<script>alert('Error updating FAQ.');</script>";
    }
}
?>
<link rel="stylesheet" href="../assets/css/styles.css"> <!-- Adjust if necessary -->
<?php include "../includes/admin_navbar.php"; ?> <!-- Adjust the path as necessary -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale =1.0">
    <title>Edit FAQ</title>
</head>
<body>

    <h2>Edit FAQ</h2>

    <form method="POST">
        <label>Question:</label><br>
        <input type="text" name="question" value="<?php echo htmlspecialchars($faq['question']); ?>" required><br><br>
       
        <label>Answer:</label><br>
        <textarea name="answer" required><?php echo htmlspecialchars($faq['answer']); ?></textarea><br><br>
       
        <button type="submit">Update FAQ</button>
    </form>

</body>
</html>