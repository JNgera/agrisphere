<?php
session_start();
include '../config/db.php'; // Ensure this path is correct

// Check if admin is logged in
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "farmer") {
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
<link rel="stylesheet" href="../assets/css/styles.css"> <!-- Adjust if necessary -->
<?php include "../includes/farmer_navbar.php"; ?> <!-- Adjust the path as necessary -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Overview</title>
    <link rel="stylesheet" href="../assets/css/styles.css"> <!-- Adjust if necessary -->
    <style>
/* Manage Orders Page Styles */
body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9; /* Light background color */
            margin: 0; /* Remove default margin */
            padding: 20px; /* Padding around the body */
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
            padding: 10px; /* Padding inside table cells */
            text-align: left; /* Align text to the left */
            border: 1px solid #ddd; /* Light border */
        }

        th {
            background-color: #007bff; /* Blue background for header */
            color: white; /* White text for header */
        }

        tr:nth-child(even) {
            background-color: #f2f2f2; /* Light gray for even rows */
        }

        a {
            color: #007bff; /* Blue color for links */
            text-decoration: none; /* Remove underline */
        }

        a:hover {
            text-decoration: underline; /* Underline on hover */
        }

        .action-links {
            display: flex; /* Flexbox for action links */
            gap: 10px; /* Space between links */
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Order Overview</h2>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
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