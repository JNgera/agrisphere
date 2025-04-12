<?php
session_start();
include '../config/db.php'; // Ensure this path is correct



// Check if feedback ID is provided in URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $feedback_id = intval($_GET['id']);

    // Prepare delete statement
    $sql = "DELETE FROM disputes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $feedback_id);

    // Execute and check success
    if ($stmt->execute()) {
        echo "<script>alert('Feedback deleted successfully!'); window.location.href='view_feedback.php';</script>";
    } else {
        echo "<script>alert('Error deleting feedback.'); window.location.href='view_feedback.php';</script>";
    }
    $stmt->close();
} else {
    echo "<script>alert('Invalid request!'); window.location.href='view_feedback.php';</script>";
}

// Close connection
$conn->close();
?>