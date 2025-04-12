<?php
session_start();
include '../config/db.php'; // Ensure this path is correct

// Check if the user is logged in and is an admin
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    echo "<script>alert('Unauthorized access!'); window.location='../../auth/login.php';</script>";
    exit();
}

// Handle admin response update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['dispute_id'])) {
    $dispute_id = $_POST['dispute_id'];
    $admin_response = $_POST['admin_response'];
    $status = $_POST['status']; // Get the updated status

    // Update the dispute in the database
    $query = "UPDATE disputes SET response = ?, status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $admin_response, $status, $dispute_id);
    $stmt->execute();
    $stmt->close();

    // Redirect to the same page to avoid resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch all disputes
$query = "SELECT * FROM disputes ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
?>
<link rel="stylesheet" href="../assets/css/styles.css"> <!-- Adjust if necessary -->
<?php include "../includes/admin_navbar.php"; ?> <!-- Adjust the path as necessary -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Disputes</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <h2>Manage Disputes</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Subject</th>
                <th>Description</th>
                <th>Status</th>
                <th>Admin Response</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['subject']) ?></td>
                        <td><?= htmlspecialchars($row['description']) ?></td>
                        <td><?= htmlspecialchars($row['status']) ?></td>
                        <td><?= isset($row['response']) && $row['response'] ? htmlspecialchars($row['response']) : 'No response yet' ?></td>
                        <td><?= htmlspecialchars($row['created_at']) ?></td>
                        <td>
                            <button onclick="document.getElementById('editForm<?= $row['id'] ?>').style.display='block'">Edit Response</button>
                        </td>
                    </tr>
                    <tr id="editForm<?= $row['id'] ?>" style="display:none;">
                        <td colspan="6">
                            <form method="POST" action="">
                                <input type="hidden" name="dispute_id" value="<?= $row['id'] ?>">
                                <label for="admin_response">Admin Response:</label>
                                <textarea id="admin_response" name="admin_response" required><?= htmlspecialchars($row['response']) ?></textarea>
                                <br>
                                <label for="status">Status:</label>
                                <select name="status" required>
                                    <option value="Pending" <?= $row['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="Resolved" <?= $row['status'] == 'Resolved' ? 'selected' : '' ?>>Resolved</option>
                                    <option value="Closed" <?= $row['status'] == 'Closed' ? 'selected' : '' ?>>Closed</option>
                                </select>
                                <br>
                                <input type="submit" value="Update Response">
                                <button type="button" onclick="document.getElementById('editForm<?= $row['id'] ?>').style.display='none'">Cancel</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No disputes found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>