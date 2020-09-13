<?php

require_once __DIR__ . "./../Db/DbHandler.php";
require_once __DIR__ . "./../Db/DbItems/user.php";
require_once __DIR__ . "./../Db/DbItems/company.php";

use db\DbHandler;
use db\User;
use db\Company;

$username = "";
$email = "";
$password = "";

$dbHandler = new DbHandler();

//register button click
if (isset($_POST['register_user'])) {

    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $queryUsernameResult = $dbHandler->userExist($username);

    if ($queryUsernameResult) {
        echo "<script type='text/javascript'>alert('USER ALREADY EXISTS!');</script>";
        header('refresh:0; URL= ./../registration.php');
    } 
    else 
    {
        $user = new User($username, $password, $email);
        $dbHandler->insertIntoUsers($user);

        $dbHandler->refresh();

        $userid = $dbHandler->selectUserId($username);

        $company = new Company('Sample', 'Sample', 'Sample', 'Sample', (int)$userid);
        $dbHandler->insertIntoCompany($company);

        echo "<script type='text/javascript'>alert('USER REGISTERED SUCCESSFULLY!');</script>";
        header('refresh:2; URL= ./../index.php');
    }
}
