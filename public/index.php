<?php

use Framework\Http\Application;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

// session_start();

/**
 * @var Framework\Http\Application $app
 * @var Psr\Container\ContainerInterface $container
 */

$container = require 'config' . DIRECTORY_SEPARATOR . 'container.php';

$app = $container->get(Application::class);

// Pipe app with middlewares
require 'config' . DIRECTORY_SEPARATOR . 'pipeline.php';

// Add routes to app
require 'config' . DIRECTORY_SEPARATOR . 'routes.php';

$request = ServerRequestFactory::fromGlobals();

$response = $app->handle($request);

$emmiter = new SapiEmitter();
$emmiter->emit($response);
