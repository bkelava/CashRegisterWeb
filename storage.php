<!DOCTYPE html>
<?php
session_start();
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/storage.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Storage</title>
</head>

<script>
    function setUI() {
        document.getElementById("producttype").readOnly = true;
    }
</script>

<body onload="javascript:setUI()">
    <form method="POST" action="scripts/dash.php">
        <div class="d-flex justify-content-left">
            <div class="buttonback">
                <input type="submit" name="back" value="Back">
            </div>
        </div>
    </form>
    <div class="d-flex justify-content-center">
        <h4>STORAGE</h4>
    </div>

    <div class="form-container">
        <form method="POST" action="scripts/dash.php">
            <script>
                function check() {
                    if (document.getElementById("service").checked) {
                        document.getElementById("producttype").setAttribute('value', "Service")
                        document.getElementById("productquantity").readOnly = true;
                        document.getElementById("productquantity").setAttribute('value', "1");
                    } else {
                        document.getElementById("productquantity").readOnly = false;
                        document.getElementById("productquantity").setAttribute('value', "0");
                        document.getElementById("producttype").setAttribute('value', "Product")
                    }


                }
            </script>
            <div class="form-group row">
                <label for="producttype" class="col-sm-2 col-form-label">Product/Service: </label>
                <div class="col-sm-10">
                    <div class="radiocontainer">
                        <label>Product</label>
                        <input id="product" class="sample" type="radio" name="type" value="Product" onclick="javascript:check()" required>
                        <label>Service</label>
                        <input id="service" class="sample" type="radio" name="type" value="Service" onclick="javascript:check()" required>
                        <input id="producttype" type="text" , class="form-control" name="producttype" placeholder="Product type" required>
                    </div>
                    <div class="radiocontainer">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="productname" class="col-sm-2 col-form-label">Product/Service name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="productname" placeholder="Product name" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="productquantity" class="col-sm-2 col-form-label">Product quantity:</label>
                <div class="col-sm-10">
                    <input id="productquantity" type="number" class="form-control" name="productquantity" placeholder="Product quantity" value="" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="productprice" class="col-sm-2 col-form-label">Product price:</label>
                <div class="col-sm-10">
                    <input id="productprice" type="number" class="form-control" name="productprice" placeholder="Product price" value="" step="0.01" required>
                </div>
            </div>

            <div class="form-group row">
                <input type="submit" class="form-control" name="saveproduct" value="Save product" required>
            </div>
        </form>
    </div>
</body>

</html>