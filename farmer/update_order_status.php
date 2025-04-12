<?php
session_start();
include '../config/db.php'; // Ensure this path is correct

// Check if admin is logged in
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "farmer") {
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
$sql = "SELECT o.id AS order_id, u.name AS customer_name, o.total_price, o.order_status
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

// Handle status update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_status = $_POST['order_status'];

    $update_sql = "UPDATE orders SET order_status = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("si", $new_status, $order_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Order status updated successfully!'); window.location='manage_orders.php';</script>";
    } else {
        echo "<script>alert('Error updating order status!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order Status</title>
    <link rel="stylesheet" href="../assets/css/styles.css"> <!-- Adjust if necessary -->
</head>
<body>
<?php include "../includes/farmer_navbar.php"; ?> <!-- Adjust the path as necessary -->

<div class="container">
    <h2>Update Order Status</h2>
    <form method="POST">
        <label>Order ID:</label>
        <input type="text" value="<?php echo htmlspecialchars($order['order_id']); ?>" disabled>

        <label>Customer Name:</label>
        <input type="text" value="<?php echo htmlspecialchars($order['customer_name']); ?>" disabled>

        <label>Total Price (KES):</label>
        <input type="text" value="KES <?php echo number_format($order['total_price'], 2); ?>" disabled>

        <label>Current Status:</label>
        <input type="text" value="<?php echo htmlspecialchars($order['order_status']); ?>" disabled>

        <label>New Status:</label>
        <select name="order_status" required>
            <option value="Pending" <?php echo ($order['order_status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
            <option value="Processing" <?php echo ($order['order_status'] == 'Processing') ? 'selected' : ''; ?>>Processing</option>
            <option value="Shipped" <?php echo ($order['order_status'] == 'Shipped') ? 'selected' : ''; ?>>Shipped</option>
            <option value="Delivered" <?php echo ($order['order_status'] == 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
            <option value="Cancelled" <?php echo ($order['order_status'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
        </select>

        <button type="submit">Update Status</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?> <!-- Adjust the path as necessary -->
</body>
</html>