<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "farmer") {
    header("Location: ../auth/login.php");
    exit();
}
?>

<link rel="stylesheet" href="../assets/css/styles.css"> <!-- Adjust if necessary -->
<?php include "../includes/farmer_navbar.php"; ?> <!-- Adjust the path as necessary -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Dashboard</title>
    <style>
        /* Farmer Dashboard Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9; /* Light background color */
            margin: 0; /* Remove default margin */
            padding: 20px; /* Padding around the body */
        }

        h2 {
            text-align: center; /* Center the welcome message */
            color: #333; /* Darker text color */
        }

        ul {
            list-style-type: none; /* Remove bullet points */
            padding: 0; /* Remove padding */
            text-align: center; /* Center the list */
        }

        li {
            margin: 10px 0; /* Space between list items */
        }

        a {
            text-decoration: none; /* Remove underline from links */
            color: #007bff; /* Blue color for links */
            font-weight: bold; /* Bold links */
        }

        a:hover {
            text-decoration: underline; /* Underline on hover */
        }

        /* Flashcard Styles */
        .flashcards {
            display: flex; /* Use flexbox for layout */
            justify-content: center; /* Center the flashcards */
            margin: 20px 0; /* Margin around the flashcards */
            gap: 20px; /* Space between flashcards */
        }

        .flashcard {
            background-color: white; /* White background for flashcards */
            border: 1px solid #ddd; /* Light border */
            border-radius: 8px; /* Rounded corners */
            padding: 20px; /* Padding inside flashcards */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            text-align: center; /* Center text in flashcards */
            flex: 1; /* Allow flashcards to grow */
            min-width: 200px; /* Minimum width for flashcards */
            color: #333; /* Darker text color */
        }

        .flashcard h3 {
            margin: 0; /* Remove default margin */
            color: #007bff; /* Blue color for headings */
        }

        .flashcard p {
            color: #555; /* Darker gray for text */
        }
    </style>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION["name"]); ?>!</h2>

    <ul>
        <li><a href="manage_products.php">Manage Products</a></li>
        <li><a href="manage_orders.php">Manage Orders</a></li>
        <li><a href="view_reports.php">View Sales Reports</a></li>
        <li><a href="raise_disputes.php">Raise Disputes</a></li>
        <li><a href="../auth/logout.php">Logout</a></li>
    </ul>

    <!-- Flashcards Section -->
    <div class="flashcards">
        <div class="flashcard">
            <h3>Manage Your Products</h3>
            <p>Effortlessly add, edit, or remove your products.</p>
        </div>
        <div class="flashcard">
            <h3>Track Your Orders</h3>
            <p>Stay updated with your order status and history.</p>
        </div>
        <div class="flashcard">
            <h3>View Sales Reports</h3>
            <p>Analyze your sales performance with detailed reports.</p>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>