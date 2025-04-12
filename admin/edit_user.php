<?php
session_start();
include '../config/db.php';

// Check if admin is logged in
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    echo "<script>alert('Unauthorized access!'); window.location='../../auth/login.php';</script>";
    exit;
}

// Check if user ID is provided
if (!isset($_GET['id'])) {
    echo "<script>alert('Invalid request!'); window.location='manage_users.php';</script>";
    exit;
}

$user_id = intval($_GET['id']);

// Fetch user details
$stmt = $conn->prepare("SELECT id, name, email, role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "<script>alert('User  not found!'); window.location='manage_users.php';</script>";
    exit;
}
?>
<nav>
    <ul>
        <li><a href="../admin/manage_users.php">Manage Users</a></li>
        <li><a href="../admin/view_feedback.php">View Feedback</a></li>
        <li><a href="../admin/manage_products.php">Manage Products</a></li>
        <li><a href="../admin/order_overview.php">Order Overview</a></li>
        <li><a href="../admin/view_reports.php">View Reports</a></li>
        <li><a href="../auth/logout.php">Logout</a></li>
    </ul>
</nav>

<style>
/* Simple Navbar Styling */

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
<?php include "../includes/admin_navbar.php"; ?> <!-- Adjust the path as necessary -->
<link rel="stylesheet" href="../assets/css/styles.css"> <!-- Adjust if necessary -->

<form action="edit_user_process.php" method="post">
    <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']); ?>">
   
    <label>Name:</label>
    <input type="text" name="name" value="<?= htmlspecialchars($user['name']); ?>" required><br><br>
   
    <label>Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required><br><br>
   
    <label>Role:</label>
    <select name="role" required>
        <option value="user" <?= $user['role'] == 'user' ? 'selected' : ''; ?>>User </option>
        <option value="farmer" <?= $user['role'] == 'farmer' ? 'selected' : ''; ?>>Farmer</option>
        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
    </select><br><br>

    <button type="submit">Update User</button>
</form>

</body>
</html>