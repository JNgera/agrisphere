<?php
session_start();
include '../config/db.php'; // Connect to database

// Redirect if cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

// Get user ID from session
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    echo "<script>alert('Please log in to proceed.'); window.location='../auth/login.php';</script>";
    exit();
}

// Calculate total price
$total_price = 0;
foreach ($_SESSION['cart'] as $item) {
    $total_price += $item['price'] * $item['quantity'];
}
?>
<?php include '../includes/user_navbar.php'; ?>
<link rel="stylesheet" href="../assets/css/styles.css"> <!-- Adjust if necessary -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        /* Checkout Page Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9; /* Light background color */
            margin: 0; /* Remove default margin */
            padding: 20px; /* Padding around the body */
        }

        .container {
            max-width: 600px; /* Limit the width of the container */
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

        label {
            display: block; /* Block display for labels */
            margin: 10px 0 5px; /* Margin for spacing */
            color: #555; /* Darker gray for labels */
        }

        input[type="text"],
        select {
            width: 100%; /* Full width for inputs and selects */
            padding: 10px; /* Padding inside inputs */
            border: 1px solid #ccc; /* Light border */
            border-radius: 4px; /* Rounded corners */
            margin-bottom: 20px; /* Space below inputs */
        }

        button {
            background-color: #28a745; /* Green background for buttons */
            color: white; /* White text */
            border: none; /* Remove border */
            padding: 10px 15px; /* Padding inside button */
            border-radius: 4px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            width: 100%; /* Full width for button */
        }

        button:hover {
            background-color: #218838; /* Darker green on hover */
        }

        h3 {
            text-align: center; /* Center the total price */
            color: #333; /* Darker text color */
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Checkout</h2>
    <form action="process_checkout.php" method="post">
        <label for="address">Delivery Address:</label>
        <input type="text" name="address" required>

        <label for="payment_method">Payment Method:</label>
        <select name="payment_method" required>
            <option value="cash">Cash on Delivery</option>
            <option value="mpesa">M-Pesa</option>
        </select>

        <h3>Total: KES <?php echo number_format($total_price, 2); ?></h3>

        <button type="submit">Place Order</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>