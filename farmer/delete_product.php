<?php
session_start();
if (!isset($_SESSION["user_id"]) ||$_SESSION["role"] !== "farmer") {
    header("Location: ../auth/login.php");
    exit();
}
include "../config/db.php";

if (isset($_GET["id"])) {
    $product_id = $_GET["id"];
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    if ($stmt->execute()) {
 echo "<script>alert('Product deleted successfully!'); window.location='manage_products.php';</script>";
    } else {
        echo "Error deleting product.";
    }
}
?>