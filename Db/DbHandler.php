<?php

namespace db;

require_once __DIR__ . "./../env.php";
require_once "DbItems/user.php";
require_once "DbItems/company.php";
require_once "DbItems/product.php";

use db\DbConfig as Config;
use db\User;
use db\Company;
use db\Product;

class DbHandler
{
    public $connection;

    public function connect()
    {
        $this->connection = new \mysqli(
            Config::HOST,
            Config::USER,
            Config::PASS,
            Config::DB
        );
        if ($this->connection->connect_errno) {
            echo "FAIL";
        }
    }

    public function disconnect()
    {
        $this->connection->close();
    }

    public function executeInsertQuery($query)
    {
        //echo $query;
        $this->connect();
        $sql = $this->connection->query($query);
        /*if ($this->connection->query($query) === TRUE) {
            echo "New record created successfully";
          } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
          }*/
        $this->disconnect();
    }

    public function executeSelectQuery($query)
    {
        $this->connect();
        $sql = $this->connection->query($query);
        $this->disconnect();
        return $sql;
    }

    public function insertIntoUsers(User $user)
    {
        //echo $user->username;
        //echo $user->email;
        //echo $user->password;
        $query = "INSERT INTO users (username, password, email) VALUES ('$user->username', '$user->password', '$user->email')";
        $this->executeInsertQuery($query);
    }

    public function executeUpdateQuery($query)
    {
        $this->connect();
        $sql = $this->connection->query($query);
        $this->disconnect();
    }

    public function insertIntoCompany(Company $company)
    {
        $query = "INSERT INTO company (name, addres, citypostal, VAT, userid) VALUES ('$company->name', '$company->addres','$company->cityandpostal','$company->VAT', $company->userid)";
        $this->executeInsertQuery($query);
    }

    public function userExist($username)
    {
        $query = "SELECT * FROM users WHERE username='$username'";
        $row = $this->executeSelectQuery($query);

        if (mysqli_num_rows($row) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function emailExist($username)
    {
        $query = "SELECT * FROM email WHERE username='$username'";
        $row = $this->executeSelectQuery($query);

        if (mysqli_num_rows($row) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function selectUserPassword($username)
    {
        $query = "SELECT password FROM users WHERE username = '$username'";
        $row = $this->executeSelectQuery($query);
        $result = mysqli_fetch_array($row);
        return $result[0];
    }

    public function selectUserId($username)
    {
        $query = "SELECT id FROM users WHERE username='$username'";
        $row = $this->executeSelectQuery($query);
        $result = mysqli_fetch_array($row);
        return $result[0];
    }

    public function selectCompanyByUserid($userid)
    {
        $query = "SELECT * FROM company WHERE userid=$userid";
        $row = $this->executeSelectQuery($query);
        $result = mysqli_fetch_array($row);
        return $result;
    }

    public function updateCompanyInfo(Company $company)
    {
        $query = "UPDATE company SET name='$company->name', addres ='$company->addres', citypostal='$company->cityandpostal', VAT='$company->VAT' WHERE userid=$company->userid";
        $this->executeUpdateQuery($query);
    }

    public function selectCompanyIdByNameAndUser($companyname, $user)
    {
        $query = "SELECT id FROM company WHERE name='$companyname' AND userid=$user";
        $row = $this->executeSelectQuery($query);
        $result = mysqli_fetch_array($row);
        return $result[0];
    }

    public function insertIntoProducts(Product $product) 
    {
        $query = "INSERT INTO products (type, name, quantity, price, companyid) VALUES ('$product->type','$product->name',$product->quantity, $product->price, $product->companyid)";
        $this->executeInsertQuery($query);
    }

    public function selectProductsForCompany($companyid)
    {
        $query = "SELECT * FROM products WHERE companyid=$companyid";
        $result = $this->executeSelectQuery($query);
        return $result;
    }

    public function updateProduct(Product $product, $id)
    {
        $query = "UPDATE products SET name = '$product->name', quantity = $product->quantity, price=$product->price WHERE id=$id";
        $this->executeUpdateQuery($query);
    }

    public function selectProductById($id)
    {
        $query = "SELECT * FROM products WHERE id=$id";
        $row = $this->executeSelectQuery($query);
        $result = mysqli_fetch_array($row);
        return $result;
    }

    public function updateProductQuantity($id, $quantity)
    {
        $query = "UPDATE products SET quantity=$quantity WHERE id=$id";
        $this->executeUpdateQuery($query);
    }

    public function selectLastReceipt($companyid)
    {
        $query = "SELECT counter FROM receipts WHERE companyid=$companyid";
        $result = $this->executeSelectQuery($query);

        $rowcount = mysqli_num_rows($result);
        
        if ($rowcount <= 0) {
            $newquery = "INSERT INTO receipts (counter, companyid) VALUES (0, $companyid)";
            $this->executeInsertQuery($newquery);
            return 1;
        }
        else {
            $row = mysqli_fetch_array($result);
            return $row[0];
        }
    }

    public function updateReceiptNumber($companyid, $number) 
    {
        $query = "UPDATE receipts SET counter=$number WHERE companyid=$companyid";
        $this->executeUpdateQuery($query);
    }

    public function deleteProduct($productid)
    {
        $query = "DELETE FROM products WHERE id=$productid";
        $this->executeUpdateQuery($query);
    }

    public function checkEmail($email) 
    {
        $query = ("SELECT * FROM users WHERE email='$email'");
        $result = $this->executeSelectQuery($query);
        if (mysqli_num_rows($result) > 0)
        {
            return true;
        }
        else 
        {
            return false;
        }

    }
}
