<?php
include '../config/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $password, $role);
    
    if ($stmt->execute()) {
        echo "<script>alert('Registration successful!'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

<div style="
    max-width: 400px; 
    margin: 50px auto; 
    background-color: #fff; 
    padding: 30px; 
    border-radius: 10px; 
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); 
    text-align: center;">
    
    <h2 style="margin-bottom: 20px;">Register</h2>
    <p style="margin-bottom: 20px;">Join us and start selling your farm produce today!</p>
    
    <form method="post">
        <input type="text" name="name" placeholder="Name" required style="
            width: 100%; 
            padding: 10px; 
            margin: 10px 0; 
            border: 1px solid #ccc; 
            border-radius: 5px;">
        
        <input type="email" name="email" placeholder="Email" required style="
            width: 100%; 
            padding: 10px; 
            margin: 10px 0; 
            border: 1px solid #ccc; 
            border-radius: 5px;">
        
        <input type="password" name="password" placeholder="Password" required style="
            width: 100%; 
            padding: 10px; 
            margin: 10px 0; 
            border: 1px solid #ccc; 
            border-radius: 5px;">
        
        <select name="role" style="
            width: 100%; 
            padding: 10px; 
            margin: 10px 0; 
            border: 1px solid #ccc; 
            border-radius: 5px;">
            <option value="user">User </option>
            <option value="farmer">Farmer</option>
            <option value="admin">Admin</option>
        </select>
        
        <button type="submit" style="
            background-color: #28a745; 
            color: white; 
            padding: 10px; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            width: 100%;">
            Register
        </button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>