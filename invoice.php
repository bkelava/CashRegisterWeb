<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/cart.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script src="library/html2canvas.min.js"></script>
    <script src="library/jspdf.min.js"></script>
    <title>Invoice</title>
</head>

<?php
session_start();
require "./Db/DbHandler.php";
require "./Db/DbItems/receipts.php";

use db\DbHandler;
use db\Receipt;

$dbHandler = new DbHandler();

$companyid = $_SESSION['companyid'];
$productsmemo = $dbHandler->selectProductsForCompany($companyid);

if (isset($_POST['addtocart'])) {
    if (isset($_COOKIE["shoppingcart"])) {
        $cookiedata = stripslashes($_COOKIE["shoppingcart"]);
        $cartdata = json_decode($cookiedata, true);
    } else {
        $cartdata = array();
    }

    $itemidlist = array_column($cartdata, 'item_id');

    if (in_array($_POST["hidden_id"], $itemidlist)) {

        //update cart
        foreach ($cartdata as $keys => $values) :
            if ($cartdata[$keys]["item_id"] == $_POST["hidden_id"]) {
                $cartdata[$keys]["item_quantity"] = $cartdata[$keys]["item_quantity"] + $_POST["quantitytoadd"];

                if ($cartdata[$keys]["item_type"] == "Product") {
                    //update cart
                    $id = $cartdata[$keys]["item_id"];
                    $temp = $_POST['hidden_quantity'];
                    $temp = $temp - 1.00;
                    $dbHandler->executeUpdateQuery("UPDATE products SET quantity=$temp WHERE id=$id");
                }
            }
        endforeach;
    } else {
        $items = array(
            'item_id' => $_POST['hidden_id'],
            'item_name' => $_POST['hidden_name'],
            'item_price' => $_POST['hidden_price'],
            'item_quantitydb' => $_POST['hidden_quantity'],
            'item_type' => $_POST['hidden_type'],
            'item_quantity' => $_POST['quantitytoadd']
        );
        $cartdata[] = $items;

        //update cart
        foreach ($cartdata as $keys => $values) :
            if ($cartdata[$keys]["item_id"] == $_POST["hidden_id"]) {

                if ($cartdata[$keys]["item_type"] == "Product") {
                    //update cart
                    $id = $cartdata[$keys]["item_id"];
                    $temp = $_POST['hidden_quantity'];
                    $temp = $temp - 1.00;
                    $dbHandler->executeUpdateQuery("UPDATE products SET quantity=$temp WHERE id=$id");
                }
            }
        endforeach;
    }

    $itemdata = json_encode($cartdata);
    setcookie('shoppingcart', $itemdata, time() + (86400 * 32)); //1 day
    header('refresh:0; URL=./../invoice.php?success=1');
}


if (isset($_GET["action"])) {
    if ($_GET["action"] == "delete") {
        $cookiedata = stripslashes($_COOKIE['shoppingcart']);
        $cartdata = json_decode($cookiedata, true);
        foreach ($cartdata as $keys => $values) :
            if ($cartdata[$keys]['item_id'] == $_GET["id"]) {
                if ($cartdata[$keys]["item_type"] == "Product") {
                    //update products
                    $id = $cartdata[$keys]["item_id"];

                    //$temp = $cartdata[$keys]["item_quantity"]; //this is

                    $temp2 = $values["item_quantitydb"];
                    //$temp3=(string)$temp2;

                    //$price = $temp+$temp2;

                    $dbHandler->executeUpdateQuery("UPDATE products SET quantity=$temp2 WHERE id=$id");
                    //$dbHandler->executeUpdateQuery("UPDATE products SET name='$temp3' WHERE id=$id");
                }

                unset($cartdata[$keys]);
                $itemdata = json_encode($cartdata);
                setcookie("shoppingcart", $itemdata, time() + (86400 * 30));

                header('refresh:0; URL=invoice.php?remove=1');
            }
        endforeach;
    }
}
?>

<body>
    <form method="POST" action="scripts/dash.php">
        <div class="d-flex justify-content-left">
            <div class="buttonback">
                <input type="submit" name="back" value="Dashboard">
            </div>
        </div>
    </form>
    <?php

    $companyid = $_SESSION['companyid'];
    $result = $dbHandler->selectProductsForCompany($companyid);
    $lastreceipt = $dbHandler->selectLastReceipt($companyid);

    $_SESSION['passid'] = $companyid;
    $_SESSION['passlastreceipt'] = $lastreceipt;

    echo "<div style='padding: 50px' class='row'>";

    foreach ($result as $row) :
        echo "<form method='POST'>";
        echo "<h4 class='text-info'> Name: " . $row['name'] . "</h4>";
        echo "<h4 class='text-danger'>Price: " . $row['price'] . "</h4>";
        echo "<label class='text-danger'>Quantity left:</label>";
        echo "<input readonly name='quantityonstorage' class='form-control' value='" . $row['quantity'] . "'</input>";
        echo "<input readonly class='form-control' type ='hidden' name='quantitytoadd' value='1'/>";

        echo "<input type='hidden' name='hidden_id' value='" . $row['id'] . "'/>";
        echo "<input type='hidden' name='hidden_name' value='" . $row['name'] . "'/>";
        echo "<input type='hidden' name='hidden_price' value='" . $row['price'] . "'/>";
        echo "<input type='hidden' name='hidden_type' value='" . $row['type'] . "'/>";
        echo "<input type='hidden' name='hidden_quantity' value='" . $row['quantity'] . "'/>";

        if ($row['type'] == "Product") {
            if ((int)$row['quantity'] == 0) {
                echo "<input type='submit' name='addtocart' style='margin-top: 5px;' class='btn btn-success' value='Add to Cart'disabled/>";
            } else {
                echo "<input type='submit' name='addtocart' style='margin-top: 5px;' class='btn btn-success' value='Add to Cart'/>";
            }
        } else {
            echo "<input type='submit' name='addtocart' style='margin-top: 5px;' class='btn btn-success' value='Add to Cart'/>";
        }
        echo "</form>";
    endforeach;
    echo "</div>";
    ?>
    <div style="clear:both">
        <br />
        <div class="w-50 p-3">
            <div id="orderdetails" class="w-75 p-5">
                <h3>Order Details -  Receipt <?php echo (string)$lastreceipt ?></h3>
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Item Name</th>
                        <th width="10%">Quantity</th>
                        <th width="20%">Price</th>
                        <th width="15%">Total</th>
                        <th width="5%">Action</th>
                    </tr>
                    <?php
                    if (isset($_COOKIE["shoppingcart"])) {
                        $total = 0;
                        $cookiedata = stripslashes($_COOKIE['shoppingcart']);
                        $cartdata = json_decode($cookiedata, true);
                        foreach ($cartdata as $key => $values) :
                            echo '<tr>';
                            echo '<td>' . $values["item_name"] . '</td>';
                            echo '<td>' . $values["item_quantity"] . '</td>';
                            echo '<td>' . $values["item_price"] . '</td>';

                            echo '<td>' . number_format($values["item_quantity"] * $values["item_price"], 2) . '</td>';

                            echo '<td><a href="invoice.php?action=delete&id=' . $values["item_id"] . '"><span class="text-danger">Remove</span></a></td>';
                            echo '</tr>';
                            $total = $total + ($values["item_quantity"] * $values["item_price"]);
                        endforeach;
                    } else {
                        echo '<tr> <td colspan="5" align="center">No Item in Cart </td> </tr>';
                    }
                    ?>
                    <tr>
                        <td colspan="3">Total </td>
                        <td align="right"><?php
                        if ($total = null) { echo number_format(0, 2); } else { echo number_format($total, 2);} ?> </td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div id="elementH"></div>

    <form method="POST" action="scripts/dash.php">
        <div class="d-flex justify-content-left">
            <div class="buttonback">
                <input type="submit" name="proceed" value="Proceed" onclick="javascript:createInvoice()">
            </div>
        </div>
    </form>
    <script type="text/javascript">
        function createInvoice() {
            var pdf = new jsPDF('p', 'pt', 'letter');
            // source can be HTML-formatted string, or a reference
            // to an actual DOM element from which the text will be scraped.
            source = $('#orderdetails')[0];

            // we support special element handlers. Register them with jQuery-style 
            // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
            // There is no support for any other type of selectors 
            // (class, of compound) at this time.
            specialElementHandlers = {
                // element with id of "bypass" - jQuery style selector
                '#orderdetails': function(element, renderer) {
                    // true = "handled elsewhere, bypass text extraction"
                    return true
                }
            };
            margins = {
                top: 80,
                bottom: 60,
                left: 40,
                width: 522
            };
            // all coords and widths are in jsPDF instance's declared units
            // 'inches' in this case
            pdf.fromHTML(
                source, // HTML string or DOM elem ref.
                margins.left, // x coord
                margins.top, { // y coord
                    'width': margins.width, // max width of content on PDF
                    'elementHandlers': specialElementHandlers
                },
                function(dispose) {
                    // dispose: object with X, Y of the last line add to the PDF 
                    //          this allow the insertion of new lines after html
                    pdf.save('Test.pdf');
                }, margins);
                document.cookie = "shoppingcart=; expires = Thu, 01 Jan 1970 00:00:00 GMT"
        }
    </script>
</body>

</html>