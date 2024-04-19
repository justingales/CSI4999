<?php
//Ashley Murad
$email = $_POST["email"];

$token = bin2hex(random_bytes(16));

$token_hash = hash("sha256", $token);

$expiry = date("Y-m-d H:i:s", time() + 60 * 30);  //prevents brute force attack using an expirey.

$mysqli = require __DIR__ . "/database.php";

$sql = "UPDATE user                
        SET reset_token_hash = ?,
            reset_token_expires_at = ?
        WHERE email = ?";        //updates the user table

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("sss", $token_hash, $expiry, $email); //3 string parameters

$stmt->execute();

if ($mysqli->affected_rows) {

    $mail = require __DIR__ . "/mailer.php";

    $mail->setFrom('noreply@gmail.com', 'no-reply');
    $mail->addAddress($email);
    $mail->Subject = "Password Reset";
    $mail->Body = <<<END

    Click <a href="http://localhost/Github/CSI4999/reset-password.php?token=$token">here</a> 
    to reset your password.

    END;

    try {

        $mail->send();

    } catch (Exception $e) {

        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";

    }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
  body {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    margin: 0;
    width: 100%;
    background-color: #f0f0f0; 
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
    font-size: 25px;
    color:rgb(22, 130, 156);
  }
  .site_name{
    font-family: "Poppins", sans-serif;
  }
</style>

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
  <p>Message sent, please check your inbox.</p>
</div>

</body>
</html>

