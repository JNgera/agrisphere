<?php
session_start();
include '../config/db.php'; // Ensure this path is correct

// Fetch all messages from the contact_us table
$sql = "SELECT * FROM contact_us ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Contact Messages</title>
    <link rel="stylesheet" href="../assets/css/styles.css"> <!-- Adjust if necessary -->
    <style>
        /* Manage Contact Messages Page Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9; /* Light background color */
            margin: 0; /* Remove default margin */
            padding: 20px; /* Padding around the body */
        }

        .container {
            max-width: 800px; /* Limit the width of the container */
            margin: 0 auto; /* Center the container */
            background-color: white; /* White background for the container */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            padding: 20px; /* Padding inside the container */
        }

        h2 {
            text-align: center; /* Center the heading */
            color: #333; /* Darker text color */
        }

        table {
            width: 100%; /* Full width for the table */
            border-collapse: collapse; /* Collapse borders */
            margin-top: 20px; /* Space above the table */
        }

        th, td {
            padding: 10px; /* Padding inside table cells */
            text-align: left; /* Align text to the left */
            border: 1px solid #ddd; /* Light border */
        }

        th {
            background-color: #007bff; /* Blue background for header */
            color: white; /* White text for header */
        }

        tr:nth-child(even) {
            background-color: #f2f2f2; /* Light gray for even rows */
        }

        tr:hover {
            background-color: #e9ecef; /* Light gray on hover */
        }

        a {
            color: #007bff; /* Blue color for links */
            text-decoration: none; /* Remove underline */
        }

        a:hover {
            text-decoration: underline; /* Underline on hover */
        }

        .btn-delete {
            color: #dc3545; /* Red color for delete button */
            font-weight: bold; /* Bold text */
        }

        .btn-delete:hover {
            text-decoration: underline; /* Underline on hover */
        }
    </style>
</head>
<body>

    <?php include "../includes/admin_navbar.php"; ?> <!-- Adjust the path as necessary -->

    <div class="container">
        <h2>📩 Manage Contact Messages</h2>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['message']) ?></td>
                        <td><?= htmlspecialchars($row['created_at']) ?></td>
                        <td>
                            <a href="delete_contact.php?id=<?= $row['id'] ?>" class="btn-delete" onclick="return confirm('Are you sure?');">❌ Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    
    <?php include '../includes/footer.php'; ?>
</body>
</html>