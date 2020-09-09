<?php

namespace db;

class Company
{
    public $name="";
    public $addres="";
    public $cityandpostal="";
    public $VAT = "";
    public $userid=0;

    function __construct($name, $addres, $citypostal, $VAT, $userid) 
    {
        $this->name = $name;
        $this->addres = $addres;
        $this->cityandpostal = $citypostal;
        $this->VAT = $VAT;
        $this->userid = $userid;
    }
}