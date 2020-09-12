<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Message</title>
</head>
<body>
    <h4>A link for reseting password has been sent to your email!</h4>
    <h5>Redirecting to log-in page in 10 seconds</h5>
    <?php 

        session_start();
        $msg = "Enter link below to reset password \n https://cashregister.herokuapp.com/";

        $email = $_SESSION['email'];

        mail($email, "CASH REGISTER -- RESET PASSWORD", $msg);

        header('refresh:10; URL=./../index.php') ;
        ?>
</body>
</html>