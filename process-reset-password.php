<?php

$token = $_POST["token"];

$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT * FROM user
        WHERE reset_token_hash = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    die("token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("token has expired");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$sql = "UPDATE user
        SET password_hash = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE id = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("ss", $password_hash, $user["id"]);
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Update</title>
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
  <p><?php
    echo "<div class='centered-message'>Password is now updated. You can now <a href='login.php'>login</a>.</div>";
    ?></p>
</div>
    
</body>
</html>

