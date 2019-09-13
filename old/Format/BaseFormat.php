<?php

namespace App\Format;
//abstract class cannot be instanciated
abstract class  BaseFormat
{

    //have to be protected to permit child class to access
    protected $data;
    //define how constructor works
    // public function __construct( array $data =[])
    // {
    //     $this->data = $data;
    // }

    public function getData()
    {
        return $this->data;
    }
    
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function __toString()
    {
        return $this->convert();
    }

    //have to be redefined inside each child classe
    public abstract function convert(): string;
}
