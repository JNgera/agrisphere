<?php
session_start();
include '../config/db.php';

// Ensure the user is logged in
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    echo "<script>alert('Please log in to place an order.'); window.location='../auth/login.php';</script>";
    exit();
}

// Check if cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

// Get form data
$address = $_POST['address'];
$payment_method = $_POST['payment_method'];

// Calculate total price
$total_price = 0;
foreach ($_SESSION['cart'] as $item) {
    $total_price += $item['price'] * $item['quantity'];
}

// Insert order into database
$sql = "INSERT INTO orders (user_id, total_price, address, payment_method, status, created_at)
        VALUES (?, ?, ?, ?, 'Pending', NOW())";

$stmt = $conn->prepare($sql);
$stmt->bind_param("idss", $user_id, $total_price, $address, $payment_method);
$stmt->execute();
$order_id = $stmt->insert_id;

// Insert ordered products into `order_items` table
$sql_product = "INSERT INTO order_products (order_id, product_id, quantity) VALUES (?, ?, ?)";
$stmt_product = $conn->prepare($sql_product);

foreach ($_SESSION['cart'] as $product_id => $item) {
    $stmt_product->bind_param("iii", $order_id, $product_id, $item['quantity']);
    $stmt_product->execute();
}

// Clear cart
unset($_SESSION['cart']);

echo "<script>alert('Order placed successfully!'); window.location='order_status.php';</script>";
?>