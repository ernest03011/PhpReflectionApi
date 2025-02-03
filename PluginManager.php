<?php

require_once 'ExamplePlugin.php';
require_once 'AnotherExamplePlugin.php';
require_once 'PluginInterface.php';

class PluginManager
{

    private $listOfClasses;
    private array $comments = [];
    private array $listOfClassesThatAreInstacesOfPluginInterface = [];

    private function listPlugins($className)
    {
        $reflection = new ReflectionClass($className);
        $isInstanceOfPluginInterface = $reflection->implementsInterface('PluginInterface');

        if ($isInstanceOfPluginInterface)
        {
            $this->listOfClassesThatAreInstacesOfPluginInterface[] = $reflection;
        }
    }

    public function getPluginsRegistry()
    {

      $this->getAllClasses();

      foreach ($this->listOfClasses as $class)
      {
          $this->listPlugins($class);
      }

    }

    private function getAllClasses()
    {
        $this->listOfClasses = get_declared_classes();
    }

    public function getComments()
    {

      foreach ($this->listOfClassesThatAreInstacesOfPluginInterface as $reflection) {
        $this->comments[] = $reflection->getDocComment();
      }

      $pattern = '/@PluginInfo\s*\(\s*(.*?)\s*\)/s';

      $parsedArray = array_map(function ($comment) use ($pattern) {
          if (preg_match($pattern, $comment, $matches)) {
              // $matches[1] will contain everything between the parentheses
              return $matches[1];
          }
          return null;
      }, $this->comments);

        echo "Comments: \n";
        var_dump($parsedArray);
        return $this->comments;
    }
}

$pluginManager = new PluginManager();
$pluginManager->getPluginsRegistry();
$pluginManager->getComments();