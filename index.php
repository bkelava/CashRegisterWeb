  <!DOCTYPE html>
  <html lang="en">

  <head>
    <title>Cash Register</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles/login.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  </head>

  <body>
    <div class="wrapper fadeInDown">
      <div id="formContent">

        <div class="fadeIn first">
          <img width="64px" height="64px" src="images/usericon.png" id="icon" alt="User Icon" />
        </div>

        <form method="POST" action="scripts/login.php">
          <input type="text" id="username" class="fadeIn first" name="username" placeholder="Username" required>
          <input type="password" id="password" class="fadeIn second" name="password" placeholder="Password" required>

          <input type="submit" class="fadeIn third" name="login_user" value="Log In">
        </form>

        <div id="formFooter" class="fadeIn fourth">
          <a class="underlineHover" href="#">Forgot Password?</a>

        </div>

        <div id="formFooter" class="fadeIn fourth">
          <p>Dont have account? <a class="underlineHover" href="registration.php">Register now!</a></p> 
        </div>

      </div>
    </div>
  </body>

  </html>