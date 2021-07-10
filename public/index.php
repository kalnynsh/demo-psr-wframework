<?php

use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

session_start();

### Initialization
$request = ServerRequestFactory::fromGlobals(
    $server = $_SERVER,
    $query = $_GET,
    $body = $_POST,
    $cookies = $_COOKIE,
    $files =  $_FILES
);

### Action
$queryParams = $request->getQueryParams();
$name = $queryParams['name'] ?? 'Guest';
$content = 'Hello, ' . $name . '!';

$response = (new HtmlResponse($content))
    ->withHeader('X-Developer', 'Denis');

$emmiter = new SapiEmitter();
$emmiter->emit($response);
