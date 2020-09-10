<?php

namespace db;

class Receipt
{

    public $number = 0;
    public $companyid = 0;

    function __construct($number, $companyid) 
    {
        $this->companyid = $companyid;
        $this->number=$number;
    }
}