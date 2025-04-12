<?php
session_start();
include '../../config/db.php';

// Check if admin is logged in
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    echo "<script>alert('Unauthorized access!'); window.location='../../auth/login.php';</script>";
    exit;
}

// Check if user ID is provided
if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);

    // Delete user from database
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('User  deleted successfully!'); window.location='manage_users.php';</script>";
    } else {
        echo "<script>alert('Error deleting user.'); window.location='manage_users.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location='manage_users.php';</script>";
}
?>