<?php

namespace db;

class User 
{
    public $username="";
    public $password="";
    public $email="";

    function __construct($username, $password, $email) 
    {
        $this->username = $username;
        $this->password = md5($password);
        $this->email = $email;
    }
}