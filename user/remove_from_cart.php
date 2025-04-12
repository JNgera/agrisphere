<<?php
session_start();

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    unset($_SESSION['cart'][$product_id]); // Remove item from cart
}

header("Location: cart.php");
exit();
?>