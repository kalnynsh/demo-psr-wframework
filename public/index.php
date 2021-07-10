<?php

use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
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
$path = $request->getUri()->getPath();

if ($path === '/') {
    $queryParams = $request->getQueryParams();
    $name = $queryParams['name'] ?? 'Guest';
    $content = 'Hello, ' . $name . '!';

    $response = new HtmlResponse($content);
} elseif ($path === '/about') {
    $response = new HtmlResponse('I am very simple site;)');
} elseif ($path === '/blog') {
    $response = new JsonResponse([
        [
            'id' => 2, 'title' => 'The second post',
        ],
        [
            'id' => 1, 'title' => 'The first post',
        ]
    ]);
} elseif(preg_match('#^/blog/(?P<id>\d+)#i', $path, $matches)) {
    $id = $matches['id'];
    $maxPastsCount = 2;

    if ($id > $maxPastsCount) {
        $response = new JsonResponse(['error' => 'Undefined page'], 404);
    }

    if ($id <= $maxPastsCount) {
        $response = new JsonResponse(['id' => $id, 'title' => 'Post #' . $id]);
    }
} else  {
    $response = new HtmlResponse('Undefined page', 404);
}


## Postprosessing
$response = $response->withHeader('X-Developer', 'Denis');

$emmiter = new SapiEmitter();
$emmiter->emit($response);
