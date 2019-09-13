<?php

namespace App;

use App\Format\JSON;
use App\Format\XML;
use App\Format\YAML;
use App\Format\FormatInterface;


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
        $container->loadServices('App\\Controller');
    }
}
