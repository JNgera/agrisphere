<?php
session_start();
include "../../config/db.php";

// Check if the farmer is logged in
if (!isset(_SESSION['farmer_id'])) {
    echo "<script>alert('Unauthorized access!'); window.location='../../auth/login.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $farmer_id = $_SESSION['farmer_id'];
    $order_id = intval($_POST['order_id']);
    $message = trim($_POST['message']);

    // Insert dispute into the databasequery = "INSERT INTO disputes (farmer_id, order_id, message, status) VALUES (?, ?, ?, 'Pending')";
    $query = "INSERT INTO disputes (farmer_id, order_id, message, status) VALUES (?, ?, ?, 'Pending')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iis", $farmer_id, $order_id, $message);
 if (stmt->execute()) {
        echo "<script>alert('Dispute raised successfully!'); window.location='view_disputes.php';</script>";
    } else {
        echo "<script>alert('Error raising dispute. Try again.'); window.history.back();</script>";
    }
}
?>