<?php
declare(strict_types=1);
namespace App\Format;

class XML extends BaseFormat implements NameFormatInterface
{
    public function convert()
    {
        $result ='';
        foreach($this->data as $key=>$value){
            $result .='<'.$key.'>'.$value.'</'.$key.'>';
      }
      return htmlspecialchars($result);
    }
    public function getName() : string
    {
        return 'XML';
    }
}