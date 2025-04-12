<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "user") {
    header("Location: ../auth/login.php");
    exit();
}
?>

<?php include '../includes/user_navbar.php'; ?>
<link rel="stylesheet" href="../assets/css/styles.css"> <!-- Adjust if necessary -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        /* Dashboard Styles */
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
            border: 1px solid #ddd; /* Light border */
            border-radius: 8px; /* Rounded corners */
            padding: 20px; /* Padding inside flashcards */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            text-align: center; /* Center text in flashcards */
            flex: 1; /* Allow flashcards to grow */
            min-width: 200px; /* Minimum width for flashcards */
            color: white; /* Text color for better contrast */
        }

        .flashcard:nth-child(1) {
            background-color: #28a745; /* Green for Customer Satisfaction */
        }

        .flashcard:nth-child(2) {
            background-color: #007bff; /* Blue for Guaranteed Quality */
        }

        .flashcard:nth-child(3) {
            background-color: #ffc107; /* Yellow for Fast Shipping */
            color: #333; /* Darker text color for better contrast */
        }

        .flashcard h3 {
            margin: 0; /* Remove default margin */
        }

        .flashcard p {
            color: inherit; /* Inherit text color from parent */
        }
    </style>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION["name"]); ?>!</h2>

    <ul>
        <li><a href="products.php">View Products</a></li>
        <li><a href="cart.php">View Cart</a></li>
        <li><a href="checkout.php">Checkout</a></li>
        <li><a href="order_status.php">Order Status</a></li>
        <li><a href="contact.php">Contact Us</a></li>
        <li><a href="../auth/logout.php">Logout</a></li>
    </ul>

    <!-- Flashcards Section -->
    <div class="flashcards">
        <div class="flashcard">
            <h3>100% Customer Satisfaction</h3>
            <p>Your happiness is our priority!</p>
        </div>
        <div class="flashcard">
            <h3>Guaranteed Quality</h3>
            <p>We ensure the best quality products.</p>
        </div>
        <div class="flashcard">
            <h3>Fast Shipping</h3>
            <p>Get your orders delivered quickly!</p>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>