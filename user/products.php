<?php
session_start();
include '../config/db.php'; // Connect to database

// Fetch products from database
$sql = "SELECT p.id, p.name, p.description, p.price, c.name AS category, p.image, p.farmer_name 
        FROM products p
        JOIN categories c ON p.category_id = c.id";
$result = $conn->query($sql);
?>
<?php include '../includes/user_navbar.php'; ?>
<link rel="stylesheet" href="../assets/css/styles.css"> <!-- Adjust if necessary -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        .product-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
            position: relative;
        }
        .product-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
        .product-card h3 {
            margin: 10px 0;
        }
        .product-card p {
            padding: 0 10px;
            color: #555;
        }
        .add-to-cart {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%; /* Make the button full width */
            margin-top: 10px; /* Add some space above the button */
        }
        .product-card:hover .add-to-cart {
            opacity: 1;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Available Products</h2>

    <div class="product-grid">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="product-card ">
                <img src="../uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Product Image">
                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                <p><?php echo htmlspecialchars($row['description']); ?></p>
                <p>KES <?php echo number_format($row['price'], 2); ?></p>
                <p>Farmer: <?php echo htmlspecialchars($row['farmer_name']); ?></p> <!-- Display farmer name -->
                <form method="post" action="add_to_cart.php">
                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                    <input type="number" name="quantity" value="1" min="1" required style="width: 60%; margin: 10px 0;">
                    <button type="submit" class="add-to-cart">Add to Cart</button>
                </form>
            </div>
        <?php } ?>
    </div>
</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>