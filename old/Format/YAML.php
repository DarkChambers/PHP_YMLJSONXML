<?php
declare(strict_types=1);
namespace App\Format;


class YAML extends BaseFormat implements NameFormatInterface, FormatInterface {
    public function convert() :string
    {
        $result ='';
        foreach($this->data as $key=>$value){
            $result .= $key.':'.$value."\n";
      }
      return htmlspecialchars($result);
    }
    public function getName() :string
    {
        return 'YAML';
    }
}