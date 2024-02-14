<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="styles.css"> 

</head>
<body>
<div class="text_box">
        <div class="site_name">SITE NAME</div>  
      </div>

<h1>Forgot Password</h1>

<form method="post" action="send-password-reset.php">
<div>
    <label for="email">Email:</label>
    <input type="email" name="email" id="email">
    </div>
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
    }

    .text_box {
      vertical-align: top;
      text-align: center;
      padding: 20px;
      border: 2px solid black; 
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      position: absolute; 
      top: 0;
      left: 10;
      width: 350px;
    }
  .site_name {
    font-size: 36px; 
    font-weight: bold;
}
    .container {
      text-align: center;
      color: blue;
    }


    button {
        background-color: white;
        color: red;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        border: 2px solid red; 
    }


    .button:hover {
      background-color: #cbcecf; /* color to change when hovering over signup/login buttons */
    }
  </style>
