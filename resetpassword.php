<!DOCTYPE html>
  <html lang="en">

  <head>
    <title>Reset Password</title>
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

        <form method="POST" action="scripts/dash.php">
            <label>E-mail addres: </label>
            <input type="text" id="username" name="mail" placeholder="E-mail" required>
            <input type="submit" id="resetpassword" name="resetpassword" value="Submit">
      </div>
    </div>
  </body>

  </html>
  žž