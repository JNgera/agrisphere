<?php
include '../config/db.php';
session_start();

// Check if admin is logged in
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    echo "<script>alert('Unauthorized access!'); window.location='../auth/login.php';</script>";
    exit;
}

// Validate input data
$name = trim($_POST['name']);
$description = trim($_POST['description']);
$price = floatval($_POST['price']);
$category_id = intval($_POST['category_id']);

if (empty($name) || empty($description) || empty($price) || empty($category_id)) {
    echo "<script>alert('All fields are required!'); window.location='add_product.php';</script>";
    exit;
}

// Handle image upload
$image = "";
if (!empty($_FILES['image']['name'])) {
    $target_dir = "../uploads/";
    $image = time() . "_" . basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image;

    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        echo "<script>alert('Image upload failed!'); window.location='add_product.php';</script>";
        exit;
    }
}

// Insert product into database
$sql = "INSERT INTO products (name, description, price, category_id, image) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdss", $name, $description, $price, $category_id, $image);

if ($stmt->execute()) {
    echo "<script>alert('Product added successfully!'); window.location='manage_products.php';</script>";
} else {
    echo "<script>alert('Error adding product.'); window.location='add_product.php';</script>";
}
?>