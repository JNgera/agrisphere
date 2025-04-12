<?php
include '../includes/header.php';
include '../config/db.php';
session_start(); // Added session_start() to manage sessions
include '../includes/navbar.php'; // Added navbar for navigation

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Added $ to _SERVER and added braces
    $name = htmlspecialchars($_POST['name']); // Added $ to name
    $email = htmlspecialchars($_POST['email']); // Added $ to email
    $message = htmlspecialchars($_POST['message']); // Added $ to message

    $sql = "INSERT INTO contact_us (name, email, message) VALUES (?, ?, ?)"; // Added $ to sql
    $stmt = $conn->prepare($sql); // Added $ to stmt

    // Check if the statement was prepared successfully
    if ($stmt) {
        $stmt->bind_param("sss", $name, $email, $message); // Added $ to name, email, message

        if ($stmt->execute()) {
            echo "<script>alert('Message sent successfully!'); window.location='contact.php';</script>";
        } else {
            echo "<script>alert('Error sending message.');</script>";
        }
    } else {
        echo "<script>alert('Error preparing statement.');</script>"; // Handle statement preparation error
    }
}
?>

<h2>Contact Us</h2>
<form method="POST">
    <label>Name:</label>
    <input type="text" name="name" required>
   
    <label>Email:</label>
    <input type="email" name="email" required>
   
    <label>Message:</label>
    <textarea name="message" required></textarea>
   
    <button type="submit">Send Message</button>
</form>

<?php include '../includes/footer.php'; ?>