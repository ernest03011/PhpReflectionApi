<?php

class Car
{
    public $color;
    private $engine;

    public function __construct($color, $engine)
    {
        $this->color = $color;
        $this->engine = $engine;
    }

    public function drive()
    {
        return "Driving!";
    }
}

$reflection = new ReflectionClass('Car');

// Get the class name
echo $reflection->getName();  // Outputs: Car

// Check if the class is user-defined or internal
var_dump($reflection->isUserDefined());  // true

// Get public properties
$publicProperties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);
foreach ($publicProperties as $prop) {
    echo $prop->getName() . "\n";  // Outputs: color
}

// Get methods
$methods = $reflection->getMethods();
foreach ($methods as $method) {
    echo $method->getName() . "\n"; // Outputs: __construct, drive
}
