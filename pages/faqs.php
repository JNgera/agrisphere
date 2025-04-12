<?php
include '../includes/header.php';
include '../config/db.php';
session_start(); // Added session_start() to manage sessions
include '../includes/navbar.php'; // Added navbar for navigation

// Fetch FAQs from database
$sql = "SELECT question, answer FROM faqs ORDER BY id DESC"; // Added $ to sql
$result = $conn->query($sql); // Added $ to conn

?>

<h2>Frequently Asked Questions</h2>

<?php while ($row = $result->fetch_assoc()) { ?> <!-- Added $ to row -->
    <div class="faq">
        <h3><?php echo htmlspecialchars($row['question']); ?></h3> <!-- Added $ to row -->
        <p><?php echo htmlspecialchars($row['answer']); ?></p> <!-- Added $ to row -->
    </div>
<?php } ?>

<?php include '../includes/footer.php'; ?>