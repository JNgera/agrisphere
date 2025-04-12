<?php
session_start();
include '../config/db.php';

// Check if admin is logged in
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    echo "<script>alert('Unauthorized access!'); window.location='../../auth/login.php';</script>";
    exit;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = intval($_POST['id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);

    // Update user details
    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $email, $role, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('User  updated successfully!'); window.location='manage_users.php';</script>";
    } else {
        echo "<script>alert('Error updating user.'); window.location='manage_users.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location='manage_users.php';</script>";
}
?>