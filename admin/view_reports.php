<?php
session_start();
include '../config/db.php'; // Ensure this path is correct

// Check if admin is logged in
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    echo "<script>alert('Unauthorized access!'); window.location='../../auth/login.php';</script>";
    exit();
}
?>
<link rel="stylesheet" href="../assets/css/styles.css"> <!-- Adjust if necessary -->
<?php include "../includes/admin_navbar.php"; ?> <!-- Adjust the path as necessary -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Reports</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9; /* Light background color */
            margin: 20px; /* Margin around the body */
        }
        h2 {
            text-align: center; /* Center the heading */
            color: #333; /* Darker text color */
        }
        .flashcard {
            background-color: #007bff; /* Blue background */
            color: white; /* White text */
            padding: 20px; /* Padding inside the flashcard */
            border-radius: 8px; /* Rounded corners */
            text-align: center; /* Center text */
            margin-bottom: 20px; /* Space below the flashcard */
        }
        table {
            width: 100%; /* Full width for the table */
            border-collapse: collapse; /* Collapse borders */
            margin-top: 20px; /* Space above the table */
            background-color: white; /* White background for the table */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
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
        .revenue-section, .detailed-revenue-section {
            margin-top: 20px; /* Space above the revenue section */
            padding: 20px; /* Padding inside the revenue section */
            background-color: #e9ecef; /* Light gray background */
            border-radius: 8px; /* Rounded corners */
            text-align: center; /* Center text */
        }
    </style>
</head>
<body>

    <h2>Sales Reports</h2>

    <!-- Date Range Filter Form -->
    <div class="date-filter">
        <form method="GET" action="">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required>
            
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" required>
            
            <input type="submit" value="Filter">
        </form>
    </div>

    <!-- Flashcard for Total Number of Orders -->
    <div class="flashcard">
        <?php
        // Initialize date range variables
        $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : null;
        $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : null;

        // Fetch total number of orders within the date range
        $totalOrdersQuery = "SELECT COUNT(*) AS total_orders FROM orders";
        if ($startDate && $endDate) {
            $totalOrdersQuery .= " WHERE order_date BETWEEN ? AND ?";
        }
        $stmt = $conn->prepare($totalOrdersQuery);
        if ($startDate && $endDate) {
            $stmt->bind_param("ss", $startDate, $endDate);
        }
        $stmt->execute();
        $totalOrdersResult = $stmt->get_result();
        $totalOrders = $totalOrdersResult->fetch_assoc()['total_orders'];
        ?>
        <h3>Total Orders: <?php echo htmlspecialchars($totalOrders); ?></h3>
    </div>

    <!-- Table for Order Status Counts -->
    <table>
        <thead>
            <tr>
                <th>Status</th>
                <th>Count</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch count of orders by status within the date range
            $statusQuery = "SELECT order_status, COUNT(*) AS count FROM orders";
            if ($startDate && $endDate) {
                $statusQuery .= " WHERE order_date BETWEEN ? AND ?";
            }
            $statusQuery .= " GROUP BY order_status";
            $stmt = $conn->prepare($statusQuery);
            if ($startDate && $endDate) {
                $stmt->bind_param("ss", $startDate, $endDate);
            }
            $stmt->execute();
            $statusResult = $stmt->get_result();

            // Initialize an array to hold status counts
            $statusCounts = [
                'Pending' => 0,
                'Shipped' => 0,
                'Processing' => 0,
                'Delivered' => 0,
                'Cancelled' => 0,
            ];

            // Populate the status counts
            while ($row = $statusResult->fetch_assoc()) {
                $status = $row['order_status'];
                if (array_key_exists($status, $statusCounts)) {
                    $statusCounts[$status] = $row['count'];
                }
            }

            // Display the counts in the table
            foreach ($statusCounts as $status => $count) {
                echo "<tr>
                        <td>" . htmlspecialchars($status) . "</td>
                        <td>" . htmlspecialchars($count) . "</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Revenue Section -->
    <div class="revenue-section">
        <?php
        // Fetch total revenue from delivered orders within the date range
        $revenueQuery = "SELECT SUM(total_price) AS total_revenue FROM orders WHERE order_status = 'Delivered'";
        if ($startDate && $endDate) { 
            $revenueQuery .= " AND order_date BETWEEN ? AND ?";
        }
        $stmt = $conn->prepare($revenueQuery);
        if ($startDate && $endDate) {
            $stmt->bind_param("ss", $startDate, $endDate);
        }
        $stmt->execute();
        $revenueResult = $stmt->get_result();
        $totalRevenue = $revenueResult->fetch_assoc()['total_revenue'] ?? 0;
        ?>
        <h3>Total Revenue from Delivered Orders: Ksh <?php echo number_format($totalRevenue, 2); ?></h3>
    </div>

    <!-- Detailed Revenue Breakdown Section -->
    <div class="detailed-revenue-section">
        <h3>Revenue Breakdown by Product</h3>
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Total Revenue</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch revenue by product
                $productRevenueQuery = "
    SELECT p.name AS product_name, SUM(o.total_price) AS total_revenue 
    FROM orders o
    JOIN products p ON o.product_id = p.id 
    WHERE o.order_status = 'Delivered'";
if ($startDate && $endDate) {
    $productRevenueQuery .= " AND o.order_date BETWEEN ? AND ?";
}

                $productRevenueQuery .= " GROUP BY p.name";
                $stmt = $conn->prepare($productRevenueQuery);
                if ($startDate && $endDate) {
                    $stmt->bind_param("ss", $startDate, $endDate);
                }
                $stmt->execute();
                $productRevenueResult = $stmt->get_result();

                // Display the revenue breakdown
                while ($row = $productRevenueResult->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['product_name']) . "</td>
                            <td>Ksh " . number_format($row['total_revenue'], 2) . "</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>