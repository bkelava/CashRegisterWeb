<!DOCTYPE html>
<html lang="en">
<?php
session_start();
require "./Db/DbHandler.php";

use db\DbHandler;

$dbHandler = new DbHandler();
$productid = $_SESSION['productid'];
$result = $dbHandler->selectProductById((int)$productid);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/viewstorage.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Edit product</title>
</head>

<body>
    <form method="POST" action="scripts/dash.php">
        <div class="d-flex justify-content-left">
            <div class="buttonback">
                <input type="submit" name="back" value="Dashboard">
            </div>
        </div>
    </form>

    <div class="optionscontainer">
        <form method="POST" action="scripts/dash.php">
            <div class="form-group row">
                <label for="productname" class="col-sm-2 col-form-label">Product/Service name:</label>
                <div class="col-sm-10">
                    <input id="productname" type="text" class="form-control" name="productname" placeholder="Product name" value="<?php echo $result['name'] ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="productquantity" class="col-sm-2 col-form-label">Product quantity:</label>
                <div class="col-sm-10">
                    <input id="productquantity" type="number" class="form-control" name="productquantity" placeholder="Product quantity" value="<?php echo $result['quantity'] ?>" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="productprice" class="col-sm-2 col-form-label">Product price:</label>
                <div class="col-sm-10">
                    <input id="productprice" type="number" class="form-control" name="productprice" placeholder="Product price" value="<?php echo $result['price'] ?>" step="0.01" required>
                </div>
            </div>

            <div class="form-group row">
                <div class="d-flex justify-content-center">
                    <input type="submit" class="form-control" name="updateproduct" value="Update product">
                </div>
            </div>
        </form>
    </div>
</body>

</html>