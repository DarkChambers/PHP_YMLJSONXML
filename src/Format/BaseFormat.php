<?php

namespace App\Format;

abstract class  BaseFormat
{

    //have to be protected to permit child class to access
    protected $data;

    public function __construct( array $data =[])
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }
    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function __toString()
    {
        return $this->convert();
    }

    //have to be redefined inside each class
    public abstract function convert();

    

}
