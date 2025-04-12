<?php
session_start();
include '../config/db.php'; // Ensure this path is correct

// Check if admin is logged in
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    echo "<script>alert('Unauthorized access!'); window.location='../../auth/login.php';</script>";
    exit();
}
?>
<link rel="stylesheet" href="../assets/css/styles.css"> <!-- Adjust if necessary -->
<?php include "../includes/admin_navbar.php"; ?> <!-- Adjust the path as necessary -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage FAQs</title>
    <style>
        table {
            width: 100%; /* Full width for the table */
            border-collapse: collapse; /* Collapse borders */
            margin-top: 20px; /* Space above the table */
        }
        th, td {
            border: 1px solid #ddd; /* Light border */
            padding: 10px; /* Padding inside table cells */
            text-align: left; /* Align text to the left */
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
        .action-links {
            display: flex; /* Use flexbox for layout */
            justify-content: space-between; /* Space between buttons */
        }
        .btn-edit, .btn-delete {
            padding: 5px 10px; /* Padding for buttons */
            border: none; /* Remove border */
            border-radius: 4px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            color: white; /* White text */
        }
        .btn-edit {
            background-color: #007bff; /* Blue background for edit button */
        }
        .btn-edit:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
        .btn-delete {
            background-color: #dc3545; /* Red background for delete button */
        }
        .btn-delete:hover {
            background-color: #c82333; /* Darker red on hover */
        }
    </style>
</head>
<body>

    <h2>Manage FAQs</h2>
   
    <a href="add_faq.php">➕ Add New FAQ</a>
   
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Question</th>
                <th>Answer</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch FAQs
            $query = "SELECT * FROM faqs ORDER BY id DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['id']) . "</td>
                            <td>" . htmlspecialchars($row['question']) . "</td>
                            <td>" . htmlspecialchars($row['answer']) . "</td>
                            <td class='action-links'>
                                <button class='btn-edit' onclick='location.href=\"edit_faq.php?id=" . $row['id'] . "\"'>✏️ Edit</button>
                                <button class='btn-delete' onclick='if(confirm(\"Are you sure?\")) location.href=\"delete_faq.php?id=" . $row['id'] . "\"'>🗑️ Delete</button>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No FAQs found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <?php include '../includes/footer.php'; ?>
</body>
</html>