<?php
include '../config/db.php';; // Ensure this path is correct
session_start();

// Check if admin is logged in
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    echo "<script>alert('Unauthorized access!'); window.location='../auth/login.php';</script>";
    exit;
}

// Get product ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid Product ID!'); window.location='manage_products.php';</script>";
    exit;
}
$product_id = intval($_GET['id']);

// Get product image path
$sql = "SELECT image FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Product not found!'); window.location='manage_products.php';</script>";
    exit;
}
$product = $result->fetch_assoc();

// Delete product from database
$sql = "DELETE FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);

if ($stmt->execute()) {
    // Delete product image from the folder
    if (!empty($product['image']) && file_exists("../uploads/" . $product['image'])) {
        unlink("../uploads/" . $product['image']);
    }

    echo "<script>alert('Product deleted successfully!'); window.location='manage_products.php';</script>";
} else {
    echo "<script>alert('Error deleting product.'); window.location='manage_products.php';</script>";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>