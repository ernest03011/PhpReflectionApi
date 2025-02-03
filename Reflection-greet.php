<?php

class Greeting
{
    public function sayHello($name, $punctuation = '!')
    {
        return "Hello, $name$punctuation";
    }
}

$reflectionClass = new ReflectionClass('Greeting');
$method = $reflectionClass->getMethod('sayHello');

// Inspect method parameters
$params = $method->getParameters();
foreach ($params as $param) {
    echo "Parameter: " . $param->getName() . "\n";
    if ($param->isDefaultValueAvailable()) {
        echo "Default Value: " . $param->getDefaultValue() . "\n";
    }
}

// Dynamically call the method
$greetingInstance = $reflectionClass->newInstance();  
$result = $method->invoke($greetingInstance, "Alice", "?");
echo $result;  // Outputs: Hello, Alice?
