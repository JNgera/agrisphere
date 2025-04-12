<?php
session_start();
include '../config/db.php';; // Ensure this path is correct

// Check if admin is logged in
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "armer") {
    echo "<script>alert('Unauthorized access!'); window.location='../../auth/login.php';</script>";
    exit;
}

// Ensure order ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid order ID!'); window.location='order_overview.php';</script>";
    exit;
}
$order_id = intval($_GET['id']);

// Fetch order details
$sql = "SELECT o.id AS order_id, u.name AS customer_name, u.email, u.phone, o.total_price, o.order_status, o.order_date, o.payment_method
        FROM orders o
        JOIN users u ON o.user_id = u.id
        WHERE o.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    echo "<script>alert('Order not found!'); window.location='order_overview.php';</script>";
    exit;
}

// Fetch ordered products
$product_sql = "SELECT p.name AS product_name, op.quantity, p.price
                FROM order_products op
                JOIN products p ON op.product_id = p.id
                WHERE op.order_id = ?";
$product_stmt = $conn->prepare($product_sql);
$product_stmt->bind_param("i", $order_id);
$product_stmt->execute();
$products_result = $product_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link rel="stylesheet" href="../assets/css/styles.css"> <!-- Adjust if necessary -->
</head>
<body>
<?php include "../includes/farmer_navbar.php"; ?> <!-- Adjust the path as necessary -->


<div class="container">
    <h2>Order Details</h2>
   
    <h3>Order Information</h3>
    <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order['order_id']); ?></p>
    <p><strong>Customer Name:</strong> <?php echo htmlspecialchars($order['customer_name']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
    <p><strong>Phone:</strong> <?php echo htmlspecialchars($order['phone']); ?></p>
    <p><strong>Order Date:</strong> <?php echo htmlspecialchars($order['order_date']); ?></p>
    <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($order['payment_method']); ?></p>
    <p><strong>Total Price (KES):</strong> KES <?php echo number_format($order['total_price'], 2); ?></p>
    <p><strong>Order Status:</strong> <?php echo htmlspecialchars($order['order_status']); ?></p>

    <h3>Products Ordered</h3>
    <table border="1">
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price (KES)</th>
        </tr>
        <?php while ($product = $products_result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                <td><?php echo htmlspecialchars($product['quantity']); ?></td>
                <td>KES <?php echo number_format($product['price'], 2); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <a href="order_overview.php" class="btn">Back to Orders</a>
</div>

</body>
</html>