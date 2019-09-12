<?php

declare(strict_types=1);

namespace App\Format;

class JSON extends BaseFormat implements FromStringInterface, NameFormatInterface
{
    // //define a constant
    // const DATA = [
    //     "succes" => "true"
    // ];

    // public static function convertData()
    // {
    //     return json_encode(self::DATA);
    // }
    public function convert()
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
