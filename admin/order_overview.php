<?php
session_start();
include '../config/db.php'; // Ensure this path is correct

// Check if admin is logged in
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    echo "<script>alert('Unauthorized access!'); window.location='../../auth/login.php';</script>";
    exit;
}

// Fetch orders from the database
$sql = "SELECT o.id AS order_id, u.name AS customer_name, o.total_price, o.order_status, o.order_date
        FROM orders o
        JOIN users u ON o.user_id = u.id
        ORDER BY o.order_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Overview</title>
    <link rel="stylesheet" href="../assets/css/styles.css"> <!-- Adjust if necessary -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9; /* Light background color */
            margin: 20px; /* Margin around the body */
        }
        .container {
            max-width: 1200px; /* Max width for the container */
            margin: 0 auto; /* Center the container */
            background-color: white; /* White background for the container */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            padding: 20px; /* Padding inside the container */
        }
        h2 {
            text-align: center; /* Center the heading */
            color: #333; /* Darker text color */
        }
        table {
            width: 100%; /* Full width for the table */
            border-collapse: collapse; /* Collapse borders */
            margin-top: 20px; /* Space above the table */
        }
        th, td {
            border: 1px solid #ddd; /* Light border */
            padding: 10px; /* Padding inside table cells */
            text-align: left; /* Align text to the left */
        }
        th {
            background-color: #007bff; /* Blue background for header */
            color: white; /* White text for header */
        }
        tr:nth-child(even) {
            background-color: #f2f2f2; /* Light gray for even rows */
        }
        tr:hover {
            background-color: #e9ecef; /* Light gray on hover */
        }
        .btn {
            display: inline-block; /* Inline block for buttons */
            padding: 5px 10px; /* Padding for buttons */
            border: none; /* Remove border */
            border-radius: 4px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            color: white; /* White text */
            text-decoration: none; /* Remove underline */
            background-color: #007bff; /* Blue background */
        }
        .btn:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
    </style>
</head>
<body>
<?php include "../includes/admin_navbar.php"; ?> <!-- Adjust the path as necessary -->
<div class="container">
    <h2>Order Overview</h2>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Total Price (KES)</th>
                <th>Status</th>
                <th>Order Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                    <td>KES <?php echo number_format($row['total_price'], 2); ?></td>
                    <td><?php echo htmlspecialchars($row['order_status']); ?></td>
                    <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                    <td>
                        <a href="update_order_status.php?id=<?php echo $row['order_id']; ?>" class="btn">Update Status</a>
                        <a href="view_order_details.php?id=<?php echo $row['order_id']; ?>" class="btn">View Details</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>