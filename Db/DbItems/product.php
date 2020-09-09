<?php

namespace db;

class Product
{
    public $name="";
    public $type="";
    public $quantity=0.00;
    public $price =0.00;
    public $companyid=0;

    function __construct($name, $type="",$quantity, $price,$companyid) 
    {
        $this->name = $name;
        $this->type =$type;
        $this->quantity =$quantity;
        $this->price =$price;
        $this->companyid=$companyid;
    }
}