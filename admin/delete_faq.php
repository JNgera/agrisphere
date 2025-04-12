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

// Delete FAQ
$query = "DELETE FROM faqs WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $faq_id);

if ($stmt->execute()) {
    echo "<script>alert('FAQ deleted successfully!'); window.location='manage_faqs.php';</script>";
} else {
    echo "<script>alert('Error deleting FAQ.');</script>";
}
?>