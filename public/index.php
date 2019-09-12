<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
//see composer .json
// use App\Format as F;
// use App\Format as F;
// use App\Format\{JSON,XML,YAML}

use App\Format\BaseFormat;
use App\Format\FromStringInterface;
use App\Format\NameFormatInterface;
use App\Format\JSON;
use App\Format\XML;
use App\Format\YAML;

// $json = new App\Format\JSON();
// $xml = new App\Format\XML();
// $yml = new App\Format\YAML();

// $json = new F\JSON();
// $xml = new F\XML();
// $yml = new F\YAML();

print("types arguments and return types<br/>");
//accept argument type instanceof BaseFormat
function convertData (BaseFormat $format){
    return $format->convert();
}

function getFormatName(NameFormatInterface $format): string {
    return $format->getName();
}
//possible nullable return
 function getFormatByName(array $formats, string $name) : ?BaseFormat {

    foreach ($formats as $format){
        if($format instanceof NameFormatInterface && $format->getName()===$name){
            return $format;
        }
    }
    return null;
}


$data = [
    "name" => "john",
    "surname" => "doe"
];
//we can pass an empty argument
$json = new JSON($data);
$xml = new XML($data);
$yml = new YAML($data);
// var_dump(convertData($json));
// print("<br/>");
// var_dump(getFormatName($json));
//$json->setData('hi hello');



 $formats = [$json, $xml, $yml];
var_dump(getFormatByName($formats,'JSON'))

// foreach ($formats as $format) { 
//     var_dump($format->getName());
//     var_dump(get_class($format));
//     var_dump($format->convert());
//     //check if objet implement an interface
//     if($format instanceof FromStringInterface){
//         var_dump($format->converFromString('{"name":"john","surname":"Doe"}')); 
//     }
   
// }


// $json->setData([]);
// var_dump($json->convert());
// var_dump((string)$json);
// var_dump($json->convert());
//acces a constant
// var_dump(JSON::DATA);
// var_dump(JSON::convertData());
// print_r("Namespaces");

// print_r($json);
// print_r($xml);
// print_r($yml);
?>