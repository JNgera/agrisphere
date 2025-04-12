<?php
session_start();
include '../config/db.php'; // Database connection

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Unauthorized access! Please login.'); window.location.href='../../auth/login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id']; // Get logged-in user's ID

// Fetch orders for the logged-in user
$sql = "SELECT id, total_price, order_status, order_date FROM orders WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<?php include '../includes/user_navbar.php'; ?>
<link rel="stylesheet" href="../assets/css/styles.css"> <!-- Adjust if necessary -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="../../assets/css/styles.css"> <!-- Include your CSS -->
    <style>
        /* My Orders Page Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9; /* Light background color */
            margin: 0; /* Remove default margin */
            padding: 20px; /* Padding around the body */
        }

        .container {
            max-width: 800px; /* Limit the width of the container */
            margin: 0 auto; /* Center the container */
            padding: 20px; /* Padding inside the container */
            background-color: white; /* White background for the container */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
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

        p {
            text-align: center; /* Center text for no orders message */
            color: #555; /* Darker gray for message */
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>My Orders</h2>
        <?php
        if ($result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>Order ID</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Order Date</th>
                        <th>Action</th>
                    </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>KES " . number_format($row['total_price'], 2) . "</td>
                        <td>{$row['order_status']}</td>
                        <td>{$row['order_date']}</td>
                        <td><a href='view_order.php?order_id={$row['id']}'>View Details</a></td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No orders found.</p>";
        }
        ?>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>