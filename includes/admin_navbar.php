<?php include '../includes/header.php'; ?>
<nav>
    <ul>
        <li><a href="../admin/dashboard.php">Dashboard</a></li>
        <li><a href="../admin/manage_users.php">Manage Users</a></li>
        <li><a href="../admin/manage_products.php">Manage Products</a></li>
        <li><a href="../admin/manage_faqs.php">Manage FAQs</a></li>
        <li><a href="../admin/manage_disputes.php">Manage Disputes</a></li>
        <li><a href="../admin/view_reports.php">View Reports</a></li>
        <li><a href="../auth/logout.php">Logout</a></li>
    </ul>
</nav>

<style>
    nav {
        background-color:rgba(33, 138, 70, 0.77); /* Blue background for the navigation */
        padding: 10px 20px; /* Padding around the navigation */
        border-radius: 5px; /* Rounded corners */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    }
    nav ul {
        list-style-type: none; /* Remove bullet points */
        margin: 0; /* Remove default margin */
        padding: 0; /* Remove default padding */
        display: flex; /* Use flexbox for horizontal layout */
        flex-direction: row; /* Ensure items are in a single row */
        overflow-x: auto; /* Allow horizontal scrolling if needed */
    }
    nav li {
        margin-right: 20px; /* Space between menu items */
    }
    nav a {
        color: white; /* White text color */
        text-decoration: none; /* Remove underline */
        padding: 8px 15px; /* Padding inside links */
        border-radius: 4px; /* Rounded corners for links */
        transition: background-color 0.3s; /* Smooth transition for hover effect */
    }
    nav a:hover {
        background-color: #0056b3; /* Darker blue on hover */
    }
</style>