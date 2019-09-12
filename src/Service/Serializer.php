<?php

namespace App\Service;

use App\Format\FormatInterface;

class Serializer

{
    private $format;
    //accept a class wich implement FormatInterface, be generic class can accept differents clases if there implement the right interface
    //fine for unit test and decoupling - use dependency injection
    public function __construct(FormatInterface $format)
    {
        $this->format = $format;
    }

    public function serialize($data): string
    {
        $this->format->setData($data);
        return $this->format->convert();
    }
}
