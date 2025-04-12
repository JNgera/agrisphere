<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "farmer") {
    header("Location: ../auth/login.php");
    exit();
}
include "../config/db.php";
?>
<link rel="stylesheet" href="../assets/css/styles.css"> <!-- Adjust if necessary -->
<?php include "../includes/farmer_navbar.php"; ?> <!-- Adjust the path as necessary -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        /* Add Product Page Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9; /* Light background color */
            margin: 0; /* Remove default margin */
            padding: 20px; /* Padding around the body */
        }

        h2 {
            text-align: center; /* Center the heading */
            color: #333; /* Darker text color */
        }

        form {
            max-width: 600px; /* Limit the width of the form */
            margin: 0 auto; /* Center the form */
            background-color: white; /* White background for the form */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            padding: 20px; /* Padding inside the form */
        }

        label {
            display: block; /* Block display for labels */
            margin: 10px 0 5px; /* Margin for spacing */
            color: #555; /* Darker gray for labels */
        }

        input[type="text"],
        input[type="number"],
        select,
        textarea {
            width: 100%; /* Full width for inputs and selects */
            padding: 10px; /* Padding inside inputs */
            border: 1px solid #ccc; /* Light border */
            border-radius: 4px; /* Rounded corners */
            margin-bottom: 20px; /* Space below inputs */
        }

        textarea {
            resize: vertical; /* Allow vertical resizing */
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
    </style>
</head>
<body>
    <h2>Add New Product</h2>
    <form action="add_product_process.php" method="POST" enctype="multipart/form-data">
        <label>Farmer Name:</label>
        <input type="text" name="farmer_name" required>
        
        <label>Product Name:</label>
        <input type="text" name="name" required>
        
        <label>Description:</label>
        <textarea name="description" required></textarea>
        
        <label>Price (KES):</label>
        <input type="number" name="price" step="0.01" required>
        
        <label>Category:</label>
        <select name="category_id" required>
            <option value="">Select Category</option>
            <?php
            $result = $conn->query("SELECT * FROM categories");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>{$row['name']}</option>";
            }
            ?>
        </select>
        
        <label>Image:</label>
        <input type="file" name="image" accept="image/*" required>
        
        <button type="submit">Add Product</button>
    </form>
    <?php include '../includes/footer.php'; ?>
</body>
</html>