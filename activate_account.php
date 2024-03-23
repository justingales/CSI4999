<?php

$token = $_GET["token"];

$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT * FROM user
        WHERE account_activation_hash = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    die("token not found");
}

$sql = "UPDATE user
        SET account_activation_hash = NULL
        WHERE id = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $user["id"]);

$stmt->execute();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Activated</title>
    <style>
  body {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    margin: 0;
    width: 100%;
  }

  .text_box {
    vertical-align: center ;
    text-align: center;
    transform: translateX(-110px) translateY(-35px);
    color: hwb(195 2% 2%);
    margin-bottom: 20px;
  }

  .logo {
    transform: translateY(-200px) translateX(175px);
  }

  p{
    color:rgb(22, 130, 156);
  }
</style>
    <style>
        .centered-message {
            text-align: center;
        }
    </style>
</head>
<body><img
  class="logo"
  src="EaseMindLogo.png"
  alt="EaseMind Logo"
  style="width: 200px; height: 200px"
/>


<div class="text_box">
  <div class="site_name" style="font-size: 90px">EaseMind</div>
  <!--website name in box-->
  <p>Account activated successfully. You can now
       <a href="login.php">log in</a>.</p>
</div>
    
</body>
</html>