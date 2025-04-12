<?php
session_start();
include '../config/db.php'; // Ensure this path is correct

// Check if the user is logged in
if (!isset($_SESSION["role"])) {
    echo "<script>alert('Unauthorized access!'); window.location='../../auth/login.php';</script>";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = $_POST['subject'];
    $description = $_POST['description'];
    $status = 'Pending'; // Default status
    $response = null; // Initially, there is no admin response

    // Insert the dispute into the database
    $query = "INSERT INTO disputes (subject, description, status, response, created_at) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssss', $subject, $description, $status, $response);
    $stmt->execute();
    $stmt->close();

    // Redirect to the same page to avoid resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
<?php include '../includes/user_navbar.php'; ?> <!-- Adjust the path as necessary -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raise Dispute</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/styles.css"> <!-- Adjust if necessary -->
    
</head>
<body>
    <h2>Raise a Dispute</h2>
    <form method="POST" action="">
        <label for="subject">Subject:</label>
        <input type="text" id="subject" name="subject" required>
        <br>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
        <br>
        <input type="submit" value="Submit Dispute">
    </form>

    <h2>Your Disputes</h2>
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
            <?php
            // Fetch disputes for the logged-in user
            $query = "SELECT * FROM disputes ORDER BY created_at DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['subject']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                    echo "<td>" . (isset($row['response']) && $row['response'] ? htmlspecialchars($row['response']) : 'No response yet') . "</td>";
                    echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No disputes found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>