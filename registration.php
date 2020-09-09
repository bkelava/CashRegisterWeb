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

        <form method="POST" action="scripts/register.php">
          
          <input type="text" id="email" class="fadeIn second" name="email" , placeholder="E-mail" required>
          <input type="text" id="username" class="fadeIn second" name="username" placeholder="Username" required>
          <input type="password" id="password" class="fadeIn second" name="password" placeholder="Password" required>

          <input type="submit" class="fadeIn third" name="register_user"value="Register">
        </form>

        <div id="formFooter" class="fadeIn fourth">
          <p>Already have account? <a class="underlineHover" href="index.php">Sign up!</a></p> 
        </div>

      </div>
    </div>
  </body>

  </html>