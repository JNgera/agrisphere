<?php
session_start();
include '../config/db.php';

// Check if admin is logged in
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    echo "<script>alert('Unauthorized access!'); window.location='../../auth/login.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User</title>
</head>
<body>
<link rel="stylesheet" href="../assets/css/styles.css"> <!-- Adjust if necessary -->
<?php include "../includes/admin_navbar.php"; ?> <!-- Adjust the path as necessary -->
<h2>Add New User</h2>

<form action="add_user_process.php" method="post">
    <label>Name:</label>
    <input type="text" name="name" required><br><br>

    <label>Email:</label>
    <input type="email" name="email" required><br><br>

    <label>Password:</label>
    <input type="password" name="password" required><br><br>

    <label>Role:</label>
    <select name="role" required>
        <option value="user">User </option>
        <option value="farmer">Farmer</option>
        <option value="admin">Admin</option>
    </select><br><br>

    <button type="submit">Add User</button>
</form>

</body>
</html>