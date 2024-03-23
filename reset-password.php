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
<html>
<head>
    
    <title>Reset Password</title>
    <meta charset="UTF-8">
    <link rel="stylesheet">
</head>
<body>
<div class="text_box">
        <div class="site_name">Easemind</div>
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

    .h1 {
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