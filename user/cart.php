<?php
session_start();
include '../config/db.php'; // Connect to database

// Check if cart exists
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total_price = 0;
?>
<?php include '../includes/user_navbar.php'; ?>
<link rel="stylesheet" href="../assets/css/styles.css"> <!-- Adjust if necessary -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        /* Shopping Cart Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9; /* Light background color */
            margin: 0; /* Remove default margin */
            padding: 20px; /* Padding around the body */
        }

        .container {
            max-width: 900px; /* Limit the width of the container */
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

        img {
            max-width: 50px; /* Limit image width */
            height: auto; /* Maintain aspect ratio */
        }

        input[type="number"] {
            width: 60px; /* Fixed width for quantity input */
            padding: 5px; /* Padding inside input */
            border: 1px solid #ccc; /* Light border */
            border-radius: 4px; /* Rounded corners */
        }

        button {
            background-color: #28a745; /* Green background for buttons */
            color: white; /* White text */
            border: none; /* Remove border */
            padding: 5px 10px; /* Padding inside button */
            border-radius: 4px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
        }

        button:hover {
            background-color: #218838; /* Darker green on hover */
        }

        .btn {
            display: inline-block; /* Inline block for button */
            background-color: #007bff; /* Blue background */
            color: white; /* White text */
            padding: 10px 15px; /* Padding inside button */
            border-radius: 4px; /* Rounded corners */
            text-decoration: none; /* Remove underline */
            text-align: center; /* Center text */
            margin-top: 20px; /* Space above button */
        }

        .btn:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        p {
            text-align: center; /* Center text for empty cart message */
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Your Cart</h2>

    <?php if (empty($cart)) { ?>
        <p>Your cart is empty.</p>
        <a href="products.php" class="btn">Continue Shopping</a>
    <?php } else { ?>

        <table>
            <tr>
                <th>Product</th>
                <th>Image</th>
                <th>Price (KES)</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>

            <?php foreach ($cart as $product_id => $item) {
                $subtotal = $item['price'] * $item['quantity'];
                $total_price += $subtotal; ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><img src="../uploads/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>"></td>
                    <td>KES <?php echo number_format($item['price'], 2); ?></td>
                    <td>
                        <form method="post" action="update_cart.php">
                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1">
                            <button type="submit">Update</button>
                        </form>
                    </td>
                    <td>KES <?php echo number_format($subtotal, 2); ?></td>
                    <td>
                        <a href="remove_from_cart.php?product_id=<?php echo $product_id; ?>" onclick="return confirm('Remove this item?')">Remove</a>
                    </td>
                </tr>
            <?php } ?>

        </table>

        <h3>Total: KES <?php echo number_format($total_price, 2); ?></h3>
        <a href="checkout.php" class="btn">Proceed to Checkout</a>
    <?php } ?>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>