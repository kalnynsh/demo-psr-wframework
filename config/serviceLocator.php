<?php

use Framework\Container\Container;

/** @var Container $serviceLocator */
$serviceLocator = new Container();

$serviceLocator->set('config', require __DIR__ . '/' . 'parameters.php');

require __DIR__ . '/' . 'dependencies.php';

return $serviceLocator;
