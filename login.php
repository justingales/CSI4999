<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {    //checks if the form has been submitted
    
    $mysqli = require __DIR__ . "/database.php"; //connect to database
    
    $sql = sprintf("SELECT * FROM user                          
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"])); //prevents sql injection
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    if ($user) {
        
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
<html>
<head>
    <title>Log In</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">    
    
</head>
<body>
    
    <div class="text_box">
        <div class="site_name">SITE NAME</div>  
      </div>
      
      
    <div class="container">
     <!--processes form when submitted; where data is sent when form is submitted-->
     <?php if ($is_invalid): ?>
        <em>Invalid login</em>
    <?php endif; ?>

     <form method="post">
        <h1>Log In</h1>

        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email"
            value="<?= htmlspecialchars ($_POST["email"] ?? "") ?>">       <!--leaves the email in box if login is invalid-->
        </div>
        
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
        </div>
        <button>Log in</button>
        
    </form>

    <a href="forgot-password.php">Forgot password?</a>
</div>
</body>
</html>

<style>
    body {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        margin: 0;
        font-family: Arial, sans-serif;
    }

    .text_box {
        vertical-align: top center;
        text-align: center;
        padding: 20px;
        border: 2px solid black; 
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        position: absolute; 
        top: 0;
        left: 10;
        width: 350px;
    }

    h1 {
        text-align: center;
    }

    form {
        width: 400px ; 
    }

    
    label {
        display: block;
        margin-bottom: 8px;
    }

    input {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
        margin-bottom: 16px;
    }

    button {
        background-color: white;
        color: red;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        border: 2px solid red; 
    }

    button:hover {
        background-color: #e9eff1;
    }
    
</style>