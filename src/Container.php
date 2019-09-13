<?php

namespace App;

//container class contain services needed
class Container
{

    private $services = [];
    private $aliases = [];

    // \Closure represent an anomymous function
    // add services to the container
    public function addServices(
        string $name,
        \Closure $closure,
        ?string $alias = null
    ): void {

        $this->services[$name] = $closure;
        if ($alias) {
            $this->addAlias($alias, $name);
        }
    }

    public function addAlias(string $alias, string $service): void
    {
        $this->aliases[$alias] = $service;
    }

    public function hasService(string $name): bool
    {
        return isset($this->services[$name]);
    }

    public function hasAlias(string $name): bool
    {
        return isset($this->aliases[$name]);
    }

    public function getService(string $name)
    {
        if (!$this->hasService($name)) {
            return null;
        }

        if ($this->services[$name] instanceof \Closure) {
            $this->services[$name] = $this->services[$name]();
        }
        return $this->services[$name];
    }

    public function getAlias(string $name)
    {
        return $this->getService($this->aliases[$name]);
    }

    public function getServices(): array
    {
        return [
            'service' => array_keys($this->services),
            'aliases' => $this->aliases
        ];
    }
    //create autoload automatically create service for classes from namespace and inject dependencies
    public function loadServices(string $namespace): void
    {
        $baseDir = __DIR__ . '\\';

        $actualDirectory = str_replace('\\', '/', $namespace);

        //var_dump($actualDirectory);
        $actualDirectory = $baseDir .  substr(
            $actualDirectory,
            strpos($actualDirectory, '/') + 1
        );
        // var_dump($actualDirectory);
        $files = array_filter(scandir($actualDirectory), function ($file) {
            return $file !== '.' && $file !== '..';
        });
        //var_dump($files);

        foreach ($files as $file) {
            $class = new \ReflectionClass(
                $namespace . '\\' . basename($file, '.php')
            );
            $serviceName = $class->getName();
            //var_dump($serviceName);
            $constructor = $class->getConstructor();
            $arguments = $constructor->getParameters();
            //paramtre to inject into service construtor
            $serviceParameters = [];
            foreach ($arguments as $argument) {
                $type = (string) $argument->getType();
                //var_dump($type);
                if ($this->hasService($type) || $this->hasAlias($type)) {
                    $serviceParameters[] = $this->getService($type) ?? $serviceParameters[] = $this->getAlias($type);
                } else {
                    $serviceParameters[] = function () use ($type) {
                        return $this->getService($type) ?? $this->getAlias($type);
                    };
                }
            }
            $this->addServices($serviceName, function () use ($serviceName, $serviceParameters){
                foreach($serviceParameters as $serviceParameter){
                    if($serviceParameter instanceof \Closure){
                        $serviceParameter = $serviceParameter();
                    }
                }
                var_dump($serviceParameters);
                //concert an array to a list a paramters
                return new $serviceName(...$serviceParameters);
            });
        }
    }
}
