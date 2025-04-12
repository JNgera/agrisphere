<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/styles.css"> <!-- Adjust if necessary -->
    <style>
        /* Admin Dashboard Styles */
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

        /* Specific flashcard colors */
        .flashcard.red {
            background-color: #f8d7da; /* Light red background */
            border-left: 5px solid #dc3545; /* Red left border */
        }

        .flashcard.green {
            background-color: #d4edda; /* Light green background */
            border-left: 5px solid #28a745; /* Green left border */
        }

        .flashcard.blue {
            background-color: #d1ecf1; /* Light blue background */
            border-left: 5px solid #17a2b8; /* Blue left border */
        }

        .flashcard.yellow {
            background-color: #fff3cd; /* Light yellow background */
            border-left: 5px solid #ffc107; /* Yellow left border */
        }
    </style>
</head>
<body>
    <?php include "../includes/admin_navbar.php"; ?> <!-- Adjust the path as necessary -->
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION["name"]); ?>!</h2>

    <ul>
        <li><a href="manage_users.php">Manage Users</a></li>
        <li><a href="view_feedback.php">View Feedback</a></li>
        <li><a href="manage_products.php">Manage Products</a></li>
        <li><a href="orders_overview.php">Orders Overview</a></li>
        <li><a href="view_reports.php">View Reports</a></li>
        <li><a href="../auth/logout.php">Logout</a></li>
    </ul>

    <!-- Flashcards Section -->
    <div class="flashcards">
        <div class="flashcard red">
            <h3>Manage Users</h3>
            <p>Control user access and permissions.</p>
        </div>
        <div class="flashcard green">
            <h3>View Feedback</h3>
            <p>Read and respond to user feedback.</p>
        </div>
        <div class="flashcard blue">
            <h3>Manage Products</h3>
            <p>Add, edit, or remove products from the inventory.</p>
        </div>
        <div class="flashcard yellow">
            <h3>Orders Overview</h3>
            <p>Monitor all orders placed by users.</p>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>