<?php
//force to check the return type
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
//see composer .json
// use App\Format as F;
// use App\Format as F;
// use App\Format\{JSON,XML,YAML}
use App\Format;
use App\Format\BaseFormat;
use App\Format\FromStringInterface;
use App\Format\NameFormatInterface;
use App\Format\FormatInterface;
use App\Format\JSON;
use App\Format\XML;
use App\Format\YAML;
use App\Service\Serializer;

// $json = new App\Format\JSON();
// $xml = new App\Format\XML();
// $yml = new App\Format\YAML();

// $json = new F\JSON();
// $xml = new F\XML();
// $yml = new F\YAML();

print("types arguments and return types<br/>");
//accept argument type instanceof BaseFormat
function convertData(BaseFormat $format)
{
    return $format->convert();
}

function getFormatName(NameFormatInterface $format): string
{
    return $format->getName();
}
//possible nullable return
function getFormatByName(array $formats, string $name): ?BaseFormat
{

    foreach ($formats as $format) {
        if ($format instanceof NameFormatInterface && $format->getName() === $name) {
            return $format;
        }
    }
    return null;
}


function findByName(string $name, array $formats): ?BaseFormat
{
    //anomyme function
    //add use($name) to be able to use the variabble out of scope
    $found = array_filter($formats, function ($format) use ($name) {
        return $format->getName() === $name;
    });
    if (count($found)) {
        return reset($found);
    }
    return null;
}


$data = [
    "name" => "john",
    "surname" => "doe"
];
//we can pass an empty argument
$json = new JSON();
$xml = new XML();
$yml = new YAML();
// var_dump(convertData($json));
// print("<br/>");
// var_dump(getFormatName($json));
//$json->setData('hi hello');
$formats = [$json, $xml, $yml];
//var_dump(findByName('XML', $formats));


//var_dump(getFormatByName($formats, 'XML'));

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

// $class = new ReflectionClass(JSON::class);
// var_dump($class);
// $method = $class->getConstructor();
// var_dump($method);
// $parameters = $method->getParameters();
// var_dump($parameters);
// foreach ($parameters as $parameter) {
//     $type = $parameter->getType();
//     var_dump((string) $type);
//     var_dump($type->isBuiltin());
//     var_dump($parameter->allowsNull());
//     var_dump($parameter->getDefaultValue());
// }

$serializer = new Serializer(new JSON());
var_dump($data);
var_dump($serializer);
var_dump($serializer->serialize($data));
