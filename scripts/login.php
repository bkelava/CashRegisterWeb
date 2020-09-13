<?php

require_once __DIR__ ."./../Db/DbHandler.php";
require_once __DIR__ . "./../Db/DbItems/user.php";

use db\Company;
use db\DbHandler;
use db\User;

session_start();

$dbHandler = new DbHandler();

if (isset($_POST['login_user'])) 
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $queryResult = $dbHandler->userExist($username);

    if ($queryResult) {

        $queryResult = $dbHandler->selectUserPassword($username);

        $hashpassword = md5($password);

        if (strcmp($queryResult, $hashpassword) == 0) {

            $userid = $dbHandler->selectUserId($username);

            $result = $dbHandler->selectCompanyByUserid($userid);

            $_SESSION['userid'] = $userid;
            $_SESSION['companyid']=$result['id'];
            $_SESSION['username']=$username;
            $_SESSION['company'] =$result['name'];

            echo "<script type='text/javascript'>alert('LOG IN SUCCESSFULL!');</script>";
            header('refresh:1; URL= ./../dashboard.php');
        }
        else {
            echo "<script type='text/javascript'>alert('INCORRECT PASSWORD!');</script>";
            header('refresh:1; URL= ./../index.php');
        }
    }
    else {
        echo "<script type='text/javascript'>alert('USER NOT FOUND!');</script>";
        header('refresh:1; URL= ./../index.php');
    }


}
