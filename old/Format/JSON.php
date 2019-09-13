<?php

declare(strict_types=1);

namespace App\Format;
//Inheritence from class an implementation of interfaces
class JSON extends BaseFormat implements FromStringInterface, NameFormatInterface, FormatInterface
{
    // //define a constant
    // const DATA = [
    //     "succes" => "true"
    // ];

    // public static function convertData()
    // {
    //     return json_encode(self::DATA);
    // }
    public function convert() :string
    {
        return json_encode($this->data);
        //return parent::convert();
    }

    public function converFromString($string)
    {
        return json_decode($string, true);
    }

    //function has to respect the signature of the interface
    public function getName(): string
    {
        return 'JSON';
    }
}
