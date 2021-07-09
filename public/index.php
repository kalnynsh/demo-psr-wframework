<?php

use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Response\HtmlResponse;

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

header(
    'HTTP/1.1 '
    . $response->getStatusCode() 
    . ' ' 
    . $response->getReasonPhrase()
);

foreach ($response->getHeaders() as $name => $value) {
    header($name . ': ' . implode(',', (array)$value));
}

echo $response->getBody();
