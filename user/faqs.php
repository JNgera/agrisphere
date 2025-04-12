<?php
session_start();
include '../config/db.php'; // Connect to database

// Fetch FAQs from the database
$query = "SELECT question, answer FROM faqs";
$result = $conn->query($query);

if (!$result) {
    echo "<p>Error fetching FAQs: " . htmlspecialchars($conn->error) . "</p>";
    exit();
}
?>
<?php include '../includes/user_navbar.php'; ?>
<link rel="stylesheet" href="../assets/css/styles.css"> <!-- Adjust if necessary -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <style>
        /* FAQ Page Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9; /* Light background color */
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px; /* Limit the width of the container */
            margin: 0 auto; /* Center the container */
            padding: 20px;
            background-color: white; /* White background for the container */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }

        h2 {
            text-align: center; /* Center the title */
            color: #333; /* Darker text color */
        }

        .faq {
            margin-bottom: 20px; /* Space between FAQs */
            padding: 15px; /* Padding inside each FAQ */
            border: 1px solid #ddd; /* Light border */
            border-radius: 5px; /* Rounded corners for each FAQ */
            background-color: #f1f1f1; /* Light background for FAQs */
        }

        .faq h3 {
            margin: 0; /* Remove default margin */
            color: #007bff; /* Blue color for questions */
            cursor: pointer; /* Pointer cursor for questions */
        }

        .faq p {
            margin: 10px 0 0; /* Margin for the answer */
            color: #555; /* Darker gray for answers */
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Frequently Asked Questions (FAQs)</h2>

    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="faq">
            <h3><?php echo htmlspecialchars($row['question']); ?></h3>
            <p><?php echo nl2br(htmlspecialchars($row['answer'])); ?></p>
        </div>
    <?php endwhile; ?>

</div>
<?php include '../includes/footer.php'; ?>
</body>
</html>