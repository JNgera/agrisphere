<?php
session_start();
include "../config/db.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You must be logged in to raise a dispute!'); window.location.href='../auth/login.php';</script>";
    exit();
}

// Initialize variables
$message = "";
$successMsg = "";
$errorMsg = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = trim($_POST["message"]);

    if (empty($message)) {
        $errorMsg = "Dispute message cannot be empty!";
    } else {
        // Insert into database without status
        $sql = "INSERT INTO disputes (message) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $message);

        if ($stmt->execute()) {
            $successMsg = "Your dispute has been submitted!";
        } else {
            $errorMsg = "Error submitting dispute: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raise a Dispute</title>
    
    <link rel="stylesheet" href="../assets/css/styles.css"> <!-- Adjust if necessary -->
    <?php include "../includes/farmer_navbar.php"; ?> <!-- Adjust the path as necessary -->

    <style>
        /* Raise a Dispute Page Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9; /* Light background color */
            margin: 0; /* Remove default margin */
            padding: 20px; /* Padding around the body */
        }

        .dispute-form {
            max-width: 600px; /* Limit the width of the form */
            margin: 0 auto; /* Center the form */
            background-color: white; /* White background for the form */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            padding: 20px; /* Padding inside the form */
        }

        h2 {
            text-align: center; /* Center the heading */
            color: #333; /* Darker text color */
        }

        label {
            display: block; /* Block display for labels */
            margin: 10px 0 5px; /* Margin for spacing */
            color: #555; /* Darker gray for labels */
        }

        textarea {
            width: 100%; /* Full width for textarea */
            padding: 10px; /* Padding inside textarea */
            border: 1px solid #ccc; /* Light border */
            border-radius: 4px; /* Rounded corners */
            margin-bottom: 20px; /* Space below textarea */
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

        .message {
            text-align: center; /* Center messages */
            margin: 10px 0; /* Margin for spacing */
        }

        .message.success {
            color: green; /* Green color for success messages */
        }

        .message.error {
            color: red; /* Red color for error messages */
        }
    </style>
</head>
<body>
    <div class="dispute-form">
        <h2>Raise a Dispute</h2>

        <?php if ($successMsg): ?>
            <p class="message success"><?php echo $successMsg; ?></p>
        <?php endif; ?>
    
        <?php if ($errorMsg): ?>
            <p class="message error"><?php echo $errorMsg; ?></p>
        <?php endif; ?>

        <form method="POST">
            <label for="message">Please describe your dispute:</label>
            <textarea name="message" id="message" rows="8" required></textarea>
            <button type="submit">Submit Dispute</button>
        </form>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>