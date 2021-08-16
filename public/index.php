<?php

use Framework\Http\Application;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

session_start();

/** 
 * @var Framework\Http\Application $app
 * @var Framework\Container\Container $serviceLocator  
 */

$serviceLocator = require 'config' . '/' . 'serviceLocator.php';

$app = $serviceLocator->get(Application::class);

require 'config' . '/' . 'pipeline.php'; 
require 'config' . '/' . 'routes.php'; 

$request = ServerRequestFactory::fromGlobals();
$response = $app->run($request);

$emmiter = new SapiEmitter();
$emmiter->emit($response);
