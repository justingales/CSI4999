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
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
  <img class="logo" src="EaseMindLogo.png" alt="EaseMind Logo" style="width: 200px; height: 200px">
    <div class="text_box">
      <div class="site_name" style="font-size: 90px">EaseMind</div>
      <!-- Website name in box -->
      <div class="button_row">
        <a href="about.html" class="aboutButton">About Us</a>
        <a href="resources.html" class="resourceButton">Resources</a>
      </div>
    </div>
  </div>
    <div class="container">
     <!--processes form when submitted; where data is sent when form is submitted-->
     <?php if ($is_invalid): ?>
        <em>Invalid login</em>
    <?php endif; ?>

     <form method="post">
       

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
        <a href="forgot-password.php" class="forgot-password">Forgot password?</a>

    </form>

    
</div>
  </body>
</html>

<style>
.aboutButton, .resourceButton {
  display: block;
  padding: 10px 20px;
  margin: 2px 25px; /* Add space between buttons */
  font-size: 16px;
  text-decoration: none;
  color: black;
  background-color: white;
  border-color: black;
  transition: background-color 0.3s ease;
  border: 2px solid black;
  border-radius: 25px;
}

body {
  display: flex;
  flex-direction: column; /* Align items in a column */
  align-items: center; /* Center items horizontally */
  justify-content: center; /* Center items vertically */
  height: 100vh;
  margin: 0;
  width: 100%;
  background-color: #f0f0f0; 
}

.container {
  text-align: center;
}

.logo {
  margin-bottom: 10px; /* Add space below the logo */
}

.text_box {
  margin-bottom: 20px; /* Add space below the text box */
  color: hwb(195 2% 2%);
  text-align: center;
}

form {
  margin-top: 20px; /* Add space above the form */
  text-align: center;
  color: black;
  font-size: 20px;
}

form label,
form input {
  display: block; /* Set display to block to stack elements */
  text-align: left;
  margin-bottom: 10px;
  width: 300px;
  height: 25px;
}
.site_name {
  font-size: 90px;
  margin-bottom: 20px; /* Add space below the site name */
  font-family: "Poppins", sans-serif;
}
.button_row {
  display: flex;
  justify-content: center; /* Center items horizontally within the row */
}

button {
  display: block;
  text-align: center;
  width: 100px;
  padding: 10px 20px;
  margin: 10px auto; /* Center horizontally */
  font-size: 16px;
  text-decoration: none;
  color: white;
  background-color: #0792ee;
  border-color: black;
  transition: background-color 0.3s ease;
  border: 2px solid black;
  border-radius: 25px;
}

.forgot-password {
  display: inline-block;
  text-decoration: none;
  margin-right: 1px;
}


</style>