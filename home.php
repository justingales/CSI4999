<?php
//Ashley Murad
session_start();

if (isset($_SESSION["user_id"])) { 
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}"; //displays the user's name
            
    $result = $mysqli->query($sql); //then run the query to get the result
    
    $user = $result->fetch_assoc();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    
    <h1>Home</h1>
    
    <?php if (isset($user)): ?>
        
        <p>Welcome <?= htmlspecialchars($user["name"]) ?></p>
        <p><a href="chatbot.html" class="button">Chat Bot</a> </p>
        <p><a href="logout.php" class= "button">Log out</a></p>
        
    <?php else: ?>
        
        <p><a href="login.php">Log in</a> or <a href="signup.html">sign up</a></p>
        
    <?php endif; ?>
    
</body>
</html>
<style>
    
body{
    width: 100%;
}

.button {
      display: block;
      padding: 10px 20px;
      margin: 10px auto;
      font-size: 16px;
      text-align: center;
      text-decoration: none;
      color: red;
      background-color: white; 
      border-color: black;
      transition: background-color 0.3s ease;
      border: 2px solid black; 
      width: 90px;
    }
    h1 {
        text-align: center;
    }

    p{
        text-align: center;
    }
</style>

