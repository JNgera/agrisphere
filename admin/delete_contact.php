<?php
session_start();
include '../config/db.php';; // Ensure this path is correct
// Check if the message ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid Message ID!'); window.location='manage_contacts.php';</script>";
    exit;
}

$id = intval($_GET['id']); // Ensure the ID is treated as an integer
$stmt = $conn->prepare("DELETE FROM contact_us WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('Message deleted successfully!'); window.location='manage_contacts.php';</script>";
} else {
    echo "<script>alert('Error deleting message!');</script>";
}

$stmt->close(); // Close the statement
$conn->close(); // Close the database connection
?>