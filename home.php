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
  
    <p class="quote">"Your journey to mental wellness begins here."</p>
  <body>
  
    <?php if (isset($user)): ?>
        
        <p class="welcome-message">Welcome <?= " to EaseMind" . " " . htmlspecialchars($user["name"]) ."!"?> </p>
        <p><a href="chatbot.html" class="button">Chat Bot</a> </p>
        <p><a href="logout.php" class= "button">Log out</a></p>
        
    <?php else: ?>
        
        <p class="welcome-message2">Please <a href="login.php" class="login-link">Log in</a> or <a href="signup.html" class="signup-link">sign up</a></p>
        
    <?php endif; ?>
    
    
</body>
</html>
<style>
         body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    text-align: center; /* Center align text */
    background-color: #f0f0f0; 
}

.container {
    margin: 0 auto; /* Center the container horizontally */
    max-width: 600px; /* Adjust as needed */
    padding: 20px;
}

.logo {
    width: 200px;
    height: 200px;
    margin-bottom: 60px;
}
a {
    color: hwb(150 32% 11%); 
}

.quote {
    font-size: 20px;
    font-style: italic;
    color: #555;
    margin-bottom: 40px;
}

.welcome-message,
.welcome-message2 {
    font-size: 30px;
    font-weight: bold;
    color: hwb(195 2% 2%);
    margin-bottom: 20px;
}

.button {
    display: inline-block; /* Display buttons as inline-block elements */
    padding: 10px 20px;
    margin: 10px; /* Adjust margin as needed */
    font-size: 16px;
    text-decoration: none;
    color: white;
    background-color: #0792ee;
    border: 2px solid black;
    border-radius: 25px;
    transition: background-color 0.3s ease;
    width: auto; /* Set width to auto to make buttons adjust to content */
    padding: 10px 65px; 
}


.button:hover {
    background-color: hwb(150 32% 11%);
}

</style>


