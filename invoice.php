<?php
session_start();
require "./Db/DbHandler.php";

use db\DbHandler;

$dbHandler = new DbHandler();
if (isset($_POST['addtocart'])) {
    if (isset($_COOKIE["shoppingcart"])) {
        $cookiedata = stripslashes($_COOKIE["shoppingcart"]);
        $cartdata = json_decode($cookiedata, true);
    } else {
        $cartdata = array();
    }

    $itemidlist = array_column($cartdata, 'item_id');

    if (in_array($_POST["hidden_id"], $itemidlist)) {
        foreach ($cartdata as $keys => $values) :
            if ($cartdata[$keys]["item_id"] == $_POST["hidden_id"]) {
                $cartdata[$keys]["item_quantity"] = $cartdata[$keys]["item_quantity"] + $_POST["quantitytoadd"];
            }
        endforeach;
    } else {
        $items = array(
            'item_id' => $_POST['hidden_id'],
            'item_name' => $_POST['hidden_name'],
            'item_price' => $_POST['hidden_price'],
            'item_quantitydb' => $_POST['hidden_quantity'],
            'item_quantity' => $_POST['quantitytoadd']
        );
        $cartdata[] = $items;
    }

    $itemdata = json_encode($cartdata);
    setcookie('shoppingcart', $itemdata, time() + (86400 * 32)); //1 day
    header('refresh:0; URL=./../invoice.php?success=1');
}

if (isset($_GET["action"])) {
    if ($_GET["action"] == "delete") {
        $cookiedata = stripslashes($_COOKIE['shoppingcart']);
        $cartdata = json_decode($cookiedata, true);
        echo $_GET["id"];
        foreach ($cartdata as $keys => $values) :
            if ($cartdata[$keys]['item_id'] == $_GET["id"]) {
                unset($cartdata[$keys]);
                $itemdata = json_encode($cartdata);
                setcookie("shoppingcart", $itemdata, time() + (86400 * 30));

                header('refresh:0; URL=invoice.php?remove=1');
            }
        endforeach;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/cart.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Invoice</title>
</head>

<script>
    function setUI() {
        //do something
    }
</script>

<body onload="javascript:setUI()">
    <?php
    $companyid = $_SESSION['companyid'];
    $result = $dbHandler->selectProductsForCompany($companyid);
    foreach ($result as $row) :
        echo "<div class='=col-md-3'>";
        echo "<form method='POST'>";
        echo "<div class='customespec' >";
        echo "<h4 class='text-info'> Name: " . $row['name'] . "</h4>";
        echo "<h4 class='text-danger'>Price: " . $row['price'] . "</h4>";
        echo "<h4 class='text-danger'>Quantity on storage: " . $row['quantity'] . "</h4>";
        echo "<input readonly class='form-control' type ='text' name='quantitytoadd' value='1'/>";

        echo "<input type='hidden' name='hidden_id' value='" . $row['id'] . "'/>";
        echo "<input type='hidden' name='hidden_name' value='" . $row['name'] . "'/>";
        echo "<input type='hidden' name='hidden_price' value='" . $row['price'] . "'/>";
        echo "<input type='hidden' name='hidden_quantity' value='" . $row['quantity'] . "'/>";
        echo "<input type='submit' name='addtocart' style='margin-top: 5px;' class='btn btn-success' value='Add to Cart'/>";

        echo "</div>";
        echo "</form>";
        echo "</div>";
    endforeach
    ?>
    <div style="clear:both">
        <br />
        <h3>Order Details</h3>
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
                    //$_SESSION["cartitemid"]= $values["item_id"];
                    echo '</tr>';
                    $total = $total + ($values["item_quantity"] * $values["item_price"]);
                endforeach;
                //echo $_GET["id"];
            } else {
                echo '<tr> <td colspan="5" align="center">No Item in Cart </td> </tr>';
            }
            ?>
            <tr>
                <td colspan="3" align="right">Total </td>
                <td align="right"><?php echo number_format($total, 2); ?> </td>
                <td></td>
            </tr>
        </table>

    </div>

</body>

</html>