<!DOCTYPE html>
<html lang="en"> <!--Ashley Murad-->
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forgot Password</title>
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
    <div class="container">
    <form method="post" action="send-password-reset.php">

    <label for="email">Email:</label>
        <input type="email" name="email" id="email">

        <button>Send</button>

    </form>
    
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
    width: 100%;
    background-color: #f0f0f0; 
  }
  button {
    display: block;
    text-align: center;
    width: 100px;
    padding: 10px 20px;
    margin: 10px;
    font-size: 16px;
    text-decoration: none;
    color: white;
    background-color: #0792ee;
    border-color: black;
    transition: background-color 0.3s ease;
    border: 2px solid black;
    border-radius: 25px;
  }

  form{
    text-align: center;
    transform: translateX(-280px) translateY(80px);
    color: black;
    display: block;
    margin-bottom: 10px;
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
 
  .text_box {
    vertical-align: top;
    text-align: center;
    transform: translateX(50px) translateY(-90px);
    color: hwb(195 2% 2%);
  }

  .logo {
    transform: translateY(-215px) translateX(330px);
  }

.site_name{
  font-family: "Poppins", sans-serif;
}
</style>