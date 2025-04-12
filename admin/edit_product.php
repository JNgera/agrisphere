<?php
include '../config/db.php';
session_start();

// Check if admin is logged in
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    echo "<script>alert('Unauthorized access!'); window.location='../auth/login.php';</script>";
    exit;
}

// Get product ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid Product ID!'); window.location='manage_products.php';</script>";
    exit;
}
$product_id = intval($_GET['id']);

// Fetch product details
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Product not found!'); window.location='manage_products.php';</script>";
    exit;
}
$product = $result->fetch_assoc();

// Fetch all categories
$categories = $conn->query("SELECT * FROM categories");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
   
    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $image = basename($_FILES['image']['name']);
        $target = "../uploads/" . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    } else {
        $image = $product['image']; // Keep old image
    }

    // Update product in the database
    $sql = "UPDATE products SET name=?, description=?, price=?, category_id=?, image=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdssi", $name, $description, $price, $category_id, $image, $product_id);

    if ($stmt->execute()) {
        echo "<script>alert('Product updated successfully!'); window.location='manage_products.php';</script>";
    } else {
        echo "<script>alert('Error updating product.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="../assets/css/styles.css"> <!-- Adjust if necessary -->
</head>
<body>
<?php include "../includes/admin_navbar.php"; ?> <!-- Adjust the path as necessary -->
    <h2>Edit Product</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <label>Product Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

        <label>Description:</label>
        <textarea name="description" required><?= htmlspecialchars($product['description']) ?></textarea>

        <label>Price (KES):</label>
        <input type="number" name="price" value="<?= htmlspecialchars($product['price']) ?>" required>

        <label>Category:</label>
        <select name="category_id" required>
            <?php while ($cat = $categories->fetch_assoc()): ?>
                <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $product['category_id']) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Current Image:</label>
        <img src="../uploads/<?= htmlspecialchars($product['image']) ?>" width="100"><br>

        <label>Change Image:</label>
        <input type="file" name="image">

        <button type="submit">Update Product</button>
    </form>
</body>
</html>