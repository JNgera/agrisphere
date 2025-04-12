<?php
session_start();
include '../config/db.php'; // Ensure this path is correct

// Check if the user is logged in (you can adjust the role check as needed)
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "farmer") {
    echo "<script>alert('Unauthorized access!'); window.location='../../auth/login.php';</script>";
    exit();
}

// Fetch disputes
$query = "SELECT * FROM disputes ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
?>
<link rel="stylesheet" href="../assets/css/styles.css"> <!-- Adjust if necessary -->
<?php include "../includes/farmer_navbar.php"; ?> <!-- Adjust the path as necessary -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Disputes</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <h2>All Disputes</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Subject</th>
                <th>Description</th>
                <th>Status</th>
                <th>Admin Response</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= htmlspecialchars($row['subject']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                    <td><?= $row['response'] ? htmlspecialchars($row['response']) : 'No response yet' ?></td>
                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php include '../includes/footer.php'; ?>
</body>
</html>