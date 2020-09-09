<!DOCTYPE html>
<html lang="en">
<?php
session_start();
require "./Db/DbHandler.php";

use db\DbHandler;

$dbHandler = new DbHandler();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/viewstorage.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>View Storage</title>
</head>

<script>
    function setUI() {
        document.getElementById("selectedoptiontext").readOnly = true;
        document.getElementById("invisible").readOnly = true;

        document.getElementById("edit").disabled = true;
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
        <div class="optionscontainer">
            <form method="POST" action="scripts/dash.php">
                <div class="form-group row">
                    <label for="producttype" class="col-sm-2 col-form-label">Product/Service: </label>
                    <div class="col-sm-10">
                        <script>
                            function selection() {
                                let selection = document.getElementById("selectionlist");
                                document.getElementById("selectedoptiontext").value = selection.options[selection.selectedIndex].text;
                                document.getElementById("invisible").value = selection.value;

                                document.getElementById("edit").disabled=false;
                            }
                        </script>
                        <?php
                        //echo $_SESSION['companyid'];
                        $companyid = $_SESSION['companyid'];
                        $result = $dbHandler->selectProductsForCompany($companyid);
                        echo '<select id="selectionlist" name="productlist" class="form-control" onchange="javascript:selection()">';
                        while ($row = $result->fetch_assoc()) {
                            echo $row['name'];
                            echo '<option id="selectedoption" value="' . $row['id'] . '">' . $row['name'] . '</option>';
                        }
                        echo '</select>';
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="productname" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <input id="selectedoptiontext" type="text" class="form-control" name="productname" placeholder="" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="productid" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <input id="invisible" type="text" class="form-control" name="productid" placeholder="" required>
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    <div class="buttonback">
                        <input id="edit" type="submit" name="editproductinfo" value="edit">
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>