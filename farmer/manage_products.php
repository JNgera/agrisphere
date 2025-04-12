<?php
include '../config/db.php';
session_start();

// Check if admin is logged in
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "farmer") {
    echo "<script>alert('Unauthorized access!'); window.location='../auth/login.php';</script>";
    exit;
}

// Fetch all products from the database
$sql = "SELECT p.id, p.name, p.description, p.price, c.name AS category, p.image, p.farmer_name 
        FROM products p
        JOIN categories c ON p.category_id = c.id
        ORDER BY p.id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - Farmer</title>
    <link rel="stylesheet" href="../assets/css/styles.css"> <!-- Adjust if necessary -->
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
        .btn {
            display: inline-block; /* Inline block for buttons */
            margin-bottom: 20px; /* Space below the button */
            padding: 10px 15px; /* Padding inside the button */
            background-color: #007bff; /* Blue background */
            color: white; /* White text */
            text-decoration: none; /* Remove underline */
            border-radius: 4px; /* Rounded corners */
        }
        .btn:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
        .product-grid {
            display: grid; /* Use grid layout */
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); /* Responsive columns */
            gap: 20px; /* Space between grid items */
            margin-top: 20px; /* Space above the grid */
        }
        .product-card {
            background-color: white; /* White background for product cards */
            border: 1px solid #ddd; /* Light border */
            border-radius: 4px; /* Rounded corners */
            padding: 15px; /* Padding inside the card */
            text-align: center; /* Center text */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow */
 }
        .product-card img {
            max-width: 100%; /* Responsive image */
            height: auto; /* Maintain aspect ratio */
            border-radius: 4px; /* Rounded corners for images */
        }
        .product-card h3 {
            font-size: 1.2em; /* Font size for product name */
            margin: 10px 0; /* Margin above and below */
        }
        .product-card p {
            font-size: 0.9em; /* Font size for description */
            color: #666; /* Gray color for description */
        }
        .product-card .price {
            font-weight: bold; /* Bold price */
            color: #333; /* Darker color for price */
        }
        .product-card .farmer-name {
            font-size: 0.9em; /* Font size for farmer name */
            color: #555; /* Slightly darker gray for farmer name */
            margin-top: 5px; /* Space above farmer name */
        }
        .action-links {
            margin-top: 10px; /* Space above action links */
        }
        .btn-edit, .btn-delete {
            padding: 5px 10px; /* Padding for buttons */
            border: none; /* Remove border */
            border-radius: 4px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            color: white; /* White text */
            text-decoration: none; /* Remove underline */
        }
        .btn-edit {
            background-color: #007bff; /* Blue background for edit button */
        }
        .btn-edit:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
        .btn-delete {
            background-color: #dc3545; /* Red background for delete button */
        }
        .btn-delete:hover {
            background-color: #c82333; /* Darker red on hover */
        }
    </style>
</head>
<body>
<?php include "../includes/farmer_navbar.php"; ?> <!-- Adjust the path as necessary -->
    <h2>Manage Products</h2>
    <a href="add_product.php" class="btn">➕ Add New Product</a>

    <div class="product-grid">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="product-card">
                <img src="../uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                <h3><?= htmlspecialchars($row['name']) ?></h3>
                <p><?= htmlspecialchars($row['description']) ?></p>
                <p class="price">KES <?= number_format($row['price'], 2) ?></p>
                <p class="farmer-name">Farmer: <?= htmlspecialchars($row['farmer_name']) ?></p> <!-- Display farmer name -->
                <div class="action-links">
                    <a href="edit_product.php?id=<?= $row['id'] ?>" class="btn-edit">✏ Edit</a>
                    <a href="delete_product.php?id=<?= $row['id'] ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this product?');">❌ Delete</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>