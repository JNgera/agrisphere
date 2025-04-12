<?php 
include '../config/db.php'; 
session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $email = $_POST['email']; 
    $password = $_POST['password']; 

    $sql = "SELECT * FROM users WHERE email=?"; 
    $stmt = $conn->prepare($sql); 
    $stmt->bind_param("s", $email); 
    $stmt->execute(); 
    $result = $stmt->get_result(); 
    $user = $result->fetch_assoc(); 

    if ($user && password_verify($password, $user['password'])) { 
        $_SESSION['user_id'] = $user['id']; 
        $_SESSION['name'] = $user['name']; 
        $_SESSION['email'] = $user['email']; 
        $_SESSION['password'] = $user['password'];   
        $_SESSION['role'] = $user['role']; 

        if ($user['role'] == 'admin') { 
            header("Location: ../admin/dashboard.php"); 
        } elseif ($user['role'] == 'farmer') { 
            header("Location: ../farmer/dashboard.php"); 
        } else { 
            header("Location: ../user/dashboard.php"); 
        } 
    } else { 
        echo "<script>alert('Invalid credentials!');</script>"; 
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
    
    <h2 style="margin-bottom: 20px;">Login</h2> 
    <form method="post"> 
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
        
        <button type="submit" style="
            background-color: #28a745; 
            color: white; 
            padding: 10px; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            width: 100%;">
            Login
        </button> 
    </form> 
</div>

<?php include '../includes/footer.php'; ?>