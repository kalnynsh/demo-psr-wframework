<?php

use Framework\Container\Container;

/** @var Container $serviceLocator */
$serviceLocator = new Container(require __DIR__. DIRECTORY_SEPARATOR . 'dependencies.php');

$serviceLocator->set('config', require __DIR__ . DIRECTORY_SEPARATOR . 'parameters.php');

return $serviceLocator;
