<?php

$token = $_GET["token"];

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

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password</title>
    <link rel="stylesheet" href="styles.css" />
  </head>
  <body>
  

    <img
      class="logo"
      src="EaseMindLogo.png"
      alt="EaseMind Logo"
      style="width: 200px; height: 200px"
    />

    <div class="text_box">
      <div class="site_name" style="font-size: 90px">EaseMind</div>
      <!--website name in box-->
    </div>

 
    <form method="post" action="process-reset-password.php">
        <h1>Reset Password</h1>
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

        <label for="password">New password:</label>
        <input type="password" id="password" name="password">

        <label for="password_confirmation">Repeat password:</label>
        <input type="password" id="password_confirmation"
               name="password_confirmation">

        <button>Send</button>
    </form>
  </body>
</html>

<style>
  body {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    margin: 0;
    width: 100%;
  }
  form{
    vertical-align: top;
    text-align: center;
    transform: translateX(-900px) translateY(-90px);
    color: hwb(195 2% 2%);
  }
  .text_box {
    vertical-align: top;
    text-align: center;
    transform: translateX(250px) translateY(-90px);
    color: hwb(195 2% 2%);
  }

  .logo {
    transform: translateY(-215px) translateX(520px);
  }

</style>
