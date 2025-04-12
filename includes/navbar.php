<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agrisphere Navigation</title>
    <style>
        /* Navbar Styles */
        nav {
            background-color: #007bff; /* Blue background */
            padding: 10px 20px; /* Padding around the navbar */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Subtle shadow for depth */
        }

        nav ul {
            list-style-type: none; /* Remove bullet points */
            padding: 0; /* Remove padding */
            margin: 0; /* Remove margin */
            display: flex; /* Use flexbox for horizontal layout */
            justify-content: space-around; /* Space items evenly */
        }

        nav ul li {
            margin: 0 15px; /* Space between items */
        }

        nav ul li a {
            text-decoration: none; /* Remove underline from links */
            color: white; /* White text color */
            font-weight: bold; /* Bold text */
            padding: 10px 15px; /* Padding for clickable area */
            border-radius: 5px; /* Rounded corners */
            transition: background-color 0.3s; /* Smooth transition for hover effect */
        }

        nav ul li a:hover {
            background-color: #0056b3; /* Darker blue on hover */
            color: white; /* Keep text white on hover */
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav>
        <ul>
            <li><a href="../agrisphere/pages/index.php">Home</a></li>
            <li><a href="../pages/contact.php">Contact</a></li>
            <li><a href="../pages/faqs.php">FAQs</a></li>
            <li><a href="../auth/login.php">Login</a></li>
            <li><a href="../auth/register.php">Register</a></li>
        </ul>
    </nav>
</body>
</html>