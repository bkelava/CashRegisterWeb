<!DOCTYPE html>

<?php
session_start();
require "./Db/DbHandler.php";

use db\DbHandler;

$dbHandler = new DbHandler();

$userid = $_SESSION['userid'];

$dbHandler = new DbHandler();
$result = $dbHandler->selectCompanyByUserid((int)$userid);
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/companyinfo.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Company Information</title>
</head>

<body>
    <div class="d-flex justify-content-center">
        <div class="divpadding">
        <h2>Company information</h2>
        </div>
        
    </div>

    <form method="POST" action="scripts/dash.php">
        <div class="d-flex justify-content-left">
            <div class="buttonback">
                <input type="submit" name="back" value="Back">
            </div>
        </div>
    </form>

    <div class="form-container">
        <form method="POST" action="scripts/dash.php">
            <div class="form-group row">

                <label for="companyname" class="col-sm-2 col-form-label">Company name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control-plaintext" name="companyname" value="<?php echo $result['name'] ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="companyaddres" class="col-sm-2 col-form-label">Company adres:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="companyaddres" placeholder="Company addres" value="<?php echo $result['addres'] ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="cityandpostal" class="col-sm-2 col-form-label">City and postal:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="cityandpostal" placeholder="City and postal" value="<?php echo $result['citypostal'] ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="VAT" class="col-sm-2 col-form-label">VAT</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="VAT" placeholder="VAT" value="<?php echo $result['VAT'] ?>" required>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <div class="buttonback">
                    <input type="submit" name="savecompanyinfo" value="Save">
                </div>
            </div>
        </form>
    </div>

</body>

</html>