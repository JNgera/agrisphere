<php
session_start();
include '../config/db.php';
//check if admin is logged in
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    echo "<script>alert('Unauthorized access!'); window.location='../../auth/login.php';</script>";
    exit;
}
//check if form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);
    $role = trim($_POST['role']);

    //insert user details
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $role);

    if ($stmt->execute()) {
        echo "<script>alert('User added successfully!'); window.location='manage_users.php';</script>";
    } else {
        echo "<script>alert('Error adding user.'); window.location='manage_users.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location='manage_users.php';</script>";
}
?>
