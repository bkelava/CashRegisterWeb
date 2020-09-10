<?php

require_once __DIR__ . "./../Db/DbHandler.php";
require_once __DIR__ . "./../Db/DbItems/user.php";
require_once __DIR__ . "./../Db/DbItems/receipts.php";

use db\DbHandler;
use db\Company;
use db\Product;
use db\Receipt;

session_start();

$dbHandler = new DbHandler();

if (isset($_POST['invoice'])) {

    $companyid = $_SESSION['companyid'];
    $_SESSION['companyid'] = $companyid;
    header('refresh:0; URL=./../invoice.php');
}

if (isset($_POST['companyinfo'])) {
    $companyid = $_SESSION['companyid'];
    $_SESSION['companyid'] = $companyid;
    header('refresh:0; URL=./../companyinformation.php');
}

if (isset($_POST['back'])) {
    $companyid = $_SESSION['companyid'];
    $_SESSION['companyid'] = $companyid;
    header('refresh:0; URL=./../dashboard.php');
}

if (isset($_POST['storage'])) {
    $companyid = $_SESSION['companyid'];
    $_SESSION['companyid'] = $companyid;
    header('refresh:0; URL=./../storage.php');
}

if (isset($_POST['addtostorage'])) {
    $companyid = $_SESSION['companyid'];
    $_SESSION['companyid'] = $companyid;
    header('refresh:0; URL=./../viewstorage.php');
}

if (isset($_POST['editproductinfo'])) {
    $companyid = $_SESSION['companyid'];
    $_SESSION['companyid'] = $companyid;
    header('refresh:0; URL=./../editproduct.php');

    $id = $_POST['productid'];

    $_SESSION['productid'] = $id;
}

if (isset($_POST['savecompanyinfo'])) {
    $companyname = $_POST['companyname'];
    $companyaddres = $_POST['companyaddres'];
    $companycityandpostal = $_POST['cityandpostal'];
    $companyVAT = $_POST['VAT'];

    $_SESSION['company'] = $companyname;

    $company = new Company($companyname, $companyaddres, $companycityandpostal, $companyVAT, (int)$_SESSION['userid']);

    $dbHandler->updateCompanyInfo($company);

    header('refresh:0; URL=./../dashboard.php');
}

if (isset($_POST['saveproduct'])) {
    $producttype = $_POST['producttype'];
    $productname = $_POST['productname'];
    $productquantity = $_POST['productquantity'];
    $productprice = $_POST['productprice'];

    $id = $_SESSION['companyid'];

    $product = new Product($productname, $producttype, $productquantity, $productprice, (int)$id);
    $dbHandler->insertIntoProducts($product);

    echo "<script type='text/javascript'>alert('PRODUCT ADDED');</script>";
    header('refresh:0; URL=./../storage.php');
}

if (isset($_POST['updateproduct'])) {
    $productid = $_SESSION['productid'];
    $productname = $_POST['productname'];
    $productquantity = $_POST['productquantity'];
    $productprice = $_POST['productprice'];

    $product = new Product($productname, "", $productquantity, $productid, "");

    $dbHandler->updateProduct($product, $productid);

    header('refresh:0; URL=./../dashboard.php');
}

if (isset($_POST['proceed'])) {
    $companyid = $_SESSION['passid'];
    $lastreceipt = $_SESSION['passlastreceipt'];

    $dbHandler->updateReceiptNumber($companyid, $lastreceipt+1);

    //setcookie("shoppingcart", "", time() - 3600);

    header('refresh:0; URL=./../dashboard.php');
}
