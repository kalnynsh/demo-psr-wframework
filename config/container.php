<?php

use Laminas\ServiceManager\ServiceManager;

$config = require __DIR__ . DIRECTORY_SEPARATOR . 'config.php';

$container = new ServiceManager($config['dependencies']);

$container->setService('config', $config);

return $container;
