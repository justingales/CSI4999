<?php

if (empty($_POST["name"])) {    //makes sure a username is entered
    die("Name is required");
}

if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("A valid email is required");     //returns false if email address is not valid 
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");  //8 char password with one letter and one number
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");                    //validates the passwords match
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT); //hashing the password to protect against hackers

$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO user (name, email, password_hash)
        VALUES (?, ?, ?)";
        
$stmt = $mysqli->stmt_init(); 

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("sss",
                  $_POST["name"],
                  $_POST["email"],
                  $password_hash);

if ($stmt->execute()) {     //prevents emails to be duplicated upon signup
   
    header("Location: signup-success.html");
    exit;
    
} else {
    
    if ($mysqli->errno === 1062) {
        die("email already taken");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}