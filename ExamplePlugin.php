<?php

require_once 'PluginInterface.php';

/**
 * Class ExamplePlugin
 *
 * @PluginInfo(
 *   name = "ExamplePlugin",
 *   description = "An example plugin to demonstrate reflection usage"
 * )
 */
class ExamplePlugin implements PluginInterface {

    public function getName()
    {
      echo "Example Plugin\n";
    }

    public function getDescription()
    {
        echo "This is an example plugin\n";
    }
}

