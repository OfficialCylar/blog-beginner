<?php

session_start();
require_once __DIR__ . "/classes/DB.php";


if($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $username = $_POST["username"];
    $password = $_POST["password"];

    $conn = new DB($username, $password);
    $conn->Signin();
} 

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<nav>
    <ul>
        <li><a href="login.php">Login</a></li>
        <li><a href="signup.php">Signup</a></li>
    </ul>
</nav>
<div class="login-container">
        <h2>Login</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="submit" value="Login">
        </form>
    </div>
    
</body>
</html>