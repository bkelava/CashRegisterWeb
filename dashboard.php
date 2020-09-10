
<?php
    session_start();
    $companyid=$_SESSION['companyid'];
    $_SESSION['companyid'] = $companyid;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles/dashboard.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Cash Register - Dashboard</title>
</head>

<body>
    <div class="">
        <h4>Company:
            <?php
            echo $_SESSION['company'];
            ?>
        </h4>
        <h4>User:
            <?php
            echo $_SESSION['username'];
            ?>
        </h4>
    </div>
    <div class="d-flex justify-content-center">
        <h2>Dashboard</h2>
    </div>
    <form method="POST" action="scripts/dash.php">
        <div class="d-flex justify-content-center">
            <input type="submit" name="companyinfo" value="Company Informations">
            <input type="submit" name="invoice" value="Create invoice">

        </div>
        <div class="d-flex justify-content-center">
            <!-- tbc <input type="submit" name="invoices" value="All invoices"> -->
            <input type="submit" name="storage" value="Add to storage">
            <input type="submit" name="addtostorage" value="View storage">
        </div>
        <div class="d-flex justify-content-center">
            <input type="submit" name="logout" value="Log Out">
        </div>
    </form>

</body>

</html>