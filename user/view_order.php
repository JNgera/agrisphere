<?php
session_start();
include '../config/db.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Unauthorized access! Please login.'); window.location.href='../../auth/login.php';</script>";
    exit();
}
$user_id = $_SESSION['user_id'];

// Ensure order ID is provided
if (!isset($_GET['order_id'])) {
    echo "<script>alert('Invalid order!'); window.location.href='order_status.php';</script>";
    exit();
}

$order_id = intval($_GET['order_id']);

// Fetch order details
$sql = "SELECT o.id, o.total_price, o.status, o.order_date
        FROM orders o
        WHERE o.id = ? AND o.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$order_result = $stmt->get_result();

if ($order_result->num_rows === 0) {
    echo "<script>alert('Order not found!'); window.location.href='order_status.php';</script>";
    exit();
}
$order = $order_result->fetch_assoc();

// Fetch ordered products
$sql_products = "SELECT p.name, op.quantity, p.price
                 FROM order_products op
                 JOIN products p ON op.product_id = p.id
                 WHERE op.order_id = ?";
$stmt_products = $conn->prepare($sql_products);
$stmt_products->bind_param("i", $order_id);
$stmt_products->execute();
$products_result = $stmt_products->get_result();
?>
<?php include '../includes/user_navbar.php'; ?>
<link rel="stylesheet" href="../assets/css/styles.css"> <!-- Adjust if necessary -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>
    

    <div class="container">
        <h2>Order Details</h2>
        <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order['id']); ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($order['status']); ?></p>
        <p><strong>Total Price:</strong> KES <?php echo number_format($order['total_price'], 2); ?></p>
        <p><strong>Order Date:</strong> <?php echo htmlspecialchars($order['order_date']); ?></p>

        <h3>Products Ordered</h3>
        <table border="1">
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price (KES)</th>
            </tr>
            <?php while ($row = $products_result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                    <td>KES <?php echo number_format($row['price'], 2); ?></td>
                </tr>
            <?php } ?>
        </table>

        <br>
        <a href="order_status.php">← Back to Orders</a>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>