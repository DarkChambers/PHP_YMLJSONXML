<?php

namespace App;

use App\Format\JSON;
use App\Format\XML;
use App\Format\YAML;
use App\Format\FormatInterface;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use App\Annotations\Route;


class Kernel
{

    private $container;

    public function __construct()
    {
        $this->container = new Container();
    }

    public function getContainer(): Container
    {
        return $this->container;
    }
    //set up everything
    public function boot()
    {
        $this->bootContainer($this->container);
    }

    public function bootContainer(Container $container)
    {
        //add service to the controller
        $container->addServices('format.json', function () use ($container) {
            return new JSON();
        });

        $container->addServices('format.xml', function () use ($container) {
            return new XML();
        });
        $container->addServices('format', function () use ($container) {
            return $container->getService('format.xml');
        }, FormatInterface::class);

        $container->loadServices('App\\Service');

        AnnotationRegistry::registerLoader('class_exists');
        $reader = new AnnotationReader();
        $routes = [];

        $container->loadServices(
            'App\\Controller',
            function (string $serviceName, \ReflectionClass $class) use ($reader, &$routes) {
                $route = $reader->getClassAnnotation($class, Route::class);

                if (!$route) {
                    return;
                }
                $baseRoute = $route->route;

                foreach ($class->getMethods() as $method) {
                    $route = $reader->getMethodAnnotation($method, Route::class);
                    if (!$route) {
                        continue;
                    }
                    $routes[str_replace('//','/',$baseRoute . $route->route)] = [
                        'service' => $serviceName,
                        'method' => $method->getName()
                    ];
                }
            }
        );
        var_dump($routes);
    }
    public function HandleRequest(){
        $uri = $_SERVER['REQUEST_URI'];
        var_dump($uri);
        if(isset($this->routes[$uri])){
            $route =$this->routes[$uri];
            $response = $this->container->getService($route['service'])->{$route['method']}();
            echo $response;
            die;
        }
    }
}
