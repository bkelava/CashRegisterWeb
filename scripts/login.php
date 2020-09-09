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
    //echo "OK";

    if ($queryResult) {
        $queryResult = $dbHandler->selectUserPassword($username);

        $hashpassword = md5($password);

        if (strcmp($queryResult, $hashpassword) == 0) {

            $userId = $dbHandler->selectUserId($username);

            $_SESSION['username'] = $username;
            $_SESSION['userid'] = $userId;

            $row = $dbHandler->selectCompanyByUserId($userId);
            if($row == null) {
                $company = new Company('Sample', 'Sample', 'Sample', 'Sample', (int)$userId);
                $_SESSION['company'] = "Sample";
                $dbHandler->insertIntoCompany($company);
            }
            $username = $_SESSION['username'];
            $userid = $dbHandler->selectUserId($username);

            $_SESSION['company'] = $row['name'];
            $company = $_SESSION['company'];
            
            $companyid=$dbHandler->selectCompanyIdByNameAndUser($company, (int)$userid);
            $_SESSION['companyid'] = $companyid;
            echo "<script type='text/javascript'>alert('LOG IN SUCCESSFULL!');</script>";
            header('refresh:0; URL= ./../dashboard.php');
        }
        else {
            echo "<script type='text/javascript'>alert('INCORRECT PASSWORD!');</script>";
            header('refresh:0; URL= ./../index.php');
        }
    }
    else {
        echo "<script type='text/javascript'>alert('USER NOT FOUND!');</script>";
        header('refresh:0; URL= ./../index.php');
    }


}
