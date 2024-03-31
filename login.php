<?php
//Ashley Murad
$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {    //checks if the form has been submitted
    
    $mysqli = require __DIR__ . "/database.php"; //connect to database
    
    $sql = sprintf("SELECT * FROM user                          
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"])); //prevents sql injection
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    if ($user && $user["account_activation_hash"] === null) {
        
        if (password_verify($_POST["password"], $user["password_hash"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            
            header("Location: home.php");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h1>Welcome to Easemind</h1>
            <form method="post">
                <div class="input-group">
                    <label for="email"><i class="fas fa-envelope"></i></label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="input-group">
                    <label for="password"><i class="fas fa-lock"></i></label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit">Log in</button>
                <div class="extra-links">
                    <a href="forgot-password.php">Forgot password?</a>
                </div>
                <?php if (isset($is_invalid) && $is_invalid): ?>
                    <p class="error-message">Invalid login. Please try again.</p>
                <?php endif; ?>
            </form>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>


<style>
    body {
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #000;
    color: #fff;
}

.container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.login-box {
    background-color: rgba(0, 0, 0, 0.8);
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
    text-align: center;
}

h1 {
    margin-bottom: 20px;
    font-size: 28px;
}

.input-group {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 8px;
    font-size: 18px;
}

input {
    width: calc(100% - 40px);
    padding: 12px;
    border: none;
    border-radius: 5px;
    background-color: rgba(255, 255, 255, 0.2);
    color: #fff;
    font-size: 16px;
}

button {
    width: calc(100% - 40px);
    padding: 12px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #0056b3;
}

.extra-links {
    margin-top: 10px;
    font-size: 16px;
}

.error-message {
    color: #ff0000;
    margin-top: 10px;
    text-align: center;
    font-size: 16px;
}

    
</style>
