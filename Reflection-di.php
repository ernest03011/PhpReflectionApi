<?php

// A sample class with a dependency
class Logger {
    public function log($message) {
        echo "[LOG]: $message\n";
    }
}

class UserService {
    protected $logger;
    protected $serviceName;

    // Note: No code directly new-ing up a Logger
    public function __construct(Logger $logger, $serviceName = "MyService")
    {
        $this->logger = $logger;
        $this->serviceName = $serviceName;
    }

    public function doAction()
    {
        $this->logger->log("Action performed in {$this->serviceName}");
    }
}

class Container
{
    public function resolve($className)
    {
        $reflectionClass = new ReflectionClass($className);
        $constructor = $reflectionClass->getConstructor();

        if (is_null($constructor)) {
            // If no constructor, just create a new instance
            return new $className;
        }

        // Get constructor parameters
        $params = $constructor->getParameters();
        $dependencies = [];

        foreach ($params as $param) {
            // If the parameter has a type (class), resolve it
            if ($paramClass = $param->getClass()) {
                $dependencies[] = $this->resolve($paramClass->getName());
            } else {
                // If it's not a class, check for a default value or pass null
                if ($param->isDefaultValueAvailable()) {
                    $dependencies[] = $param->getDefaultValue();
                } else {
                    $dependencies[] = null;
                }
            }
        }

        // Create a new instance with all resolved dependencies
        return $reflectionClass->newInstanceArgs($dependencies);
    }
}

// Usage:
$container = new Container();
$userService = $container->resolve('UserService');
$userService->doAction();
// Outputs: [LOG]: Action performed in MyService
