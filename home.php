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
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Simple Chat</title>
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <img
    class="logo"
    src="EaseMindLogo.png"
    alt="EaseMind Logo"
    style="width: 200px; height: 200px"
  />
  <body>
    
    <?php if (isset($user)): ?>
        
        <p class="welcome-message">Welcome <?= " to EaseMind " . htmlspecialchars($user["name"]) ?></p>
        <p><a href="chatbot.html" class="button">Chat Bot</a> </p>
        <p><a href="logout.php" class= "button">Log out</a></p>
        
    <?php else: ?>
        
        <p><a href="login.php">Log in</a> or <a href="signup.html">sign up</a></p>
        
    <?php endif; ?>
    
</body>
</html>
<style>
     .welcome-message {
    font-size: 50px; 
    font-weight: bold; 
    color: hwb(195 2% 2%);
    vertical-align: top;
    text-align: center;
    transform: translateX(2px) translateY(-50px);
  }
    .button {
    display: block;
    text-align: center;
    width: 100px;
    padding: 10px 20px;
    margin: 10px;
    font-size: 16px;
    text-decoration: none;
    color: white;
    background-color: #0792ee;
    border-color: black;
    transition: background-color 0.3s ease;
    border: 2px solid black;
    border-radius: 25px;
    transform: translateX(670px) translateY(-50px)
  }

  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    width: 100%;
    overflow: hidden;
  }

  .logo {
    transform: translateX(650px);
  }

</style>


