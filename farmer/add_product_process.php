<?php
session_start();
include "../config/db.php"; // Ensure this file contains the correct database connection

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    $farmer_name = trim($_POST['farmer_name']); // Capture farmer name
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = isset($_POST["price"]) ? floatval($_POST["price"]) : 0;
    $category_id = isset($_POST["category_id"]) ? intval($_POST["category_id"]) : 0;
    $farmer_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : 0;

    // Check required fields
    if (empty($farmer_name) || empty($name) || empty($description) || $price <= 0 || $category_id <= 0 || $farmer_id <= 0) {
        echo "<script>alert('All fields are required.'); window.location.href='add_product.php';</script>";
        exit();
    }

    // Handle image upload
    $image = "";
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $target_dir = "C:/xampp/htdocs/agrisphere/uploads/"; // Adjust the path as necessary
        $image = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image;

        // Check if the file is an actual image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            echo "<script>alert('File is not an image.'); window.location.href='add_product.php';</script>";
            exit();
        }

        // Move the uploaded file
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "<script>alert('Image upload failed. Please try again.'); window.location.href='add_product.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Image is required.'); window.location.href='add_product.php';</script>";
        exit();
    }

    // Insert product into the database
    $sql = "INSERT INTO products (farmer_name, name, description, price, category_id, farmer_id, image) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdiss", $farmer_name, $name, $description, $price, $category_id, $farmer_id, $image);

    if ($stmt->execute()) {
        echo "<script>alert('Product added successfully!'); window.location.href='manage_products.php';</script>";
    } else {
        echo "<script>alert('Error adding product. Please try again.'); window.location.href='add_product.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Invalid request.'); window.location.href='add_product.php';</script>";
}
?>