<?php

$email = $_POST["email"];

$token = bin2hex(random_bytes(16));

$token_hash = hash("sha256", $token);

$expiry = date("Y-m-d H:i:s", time() + 60 * 30);  //prevents brute force attack

$mysqli = require __DIR__ . "/database.php";

$sql = "UPDATE user                
        SET reset_token_hash = ?,
            reset_token_expires_at = ?
        WHERE email = ?";        //updates the user table

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("sss", $token_hash, $expiry, $email); //3 string parameters

$stmt->execute();

