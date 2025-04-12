<?php
include "../config/db.php"; // Ensure correct path to database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get product details from the form
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
if (!empty($_FILES["image"]["name"])) {
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $current_image = $_POST['current_image']; // Hidden input field to keep old image

    // Handle image upload (if a new image is provided)
    $target_dir = "../../agrisphere/uploads/"; // Path where images will be stored
    $image = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Image upload successful
    } else {
        echo "<script>alert('Image upload failed. Using previous image.');</script>";
        $image = $current_image; // Keep the old image if upload fails
    }
} else {
    $image = $_POST['current_image']; // Use the current image if no new image is uploaded
}
}

// Prepare SQL query
$sql = "UPDATE products SET name=?, description=?, price=?, category_id=?, image=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdisi", $name, $description, $price, $category_id, $image, $product_id);

// Execute query and check if update was successful
if ($stmt->execute()) {
    echo "<script>alert('Product updated successfully!'); window.location='manage_products.php';</script>";
} else {
    echo "Error updating product: " . $stmt->error;
}

$stmt->close();
$conn->close();

?>