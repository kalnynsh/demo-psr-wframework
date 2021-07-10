<?php

use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Psr\Http\Message\ServerRequestInterface;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

session_start();

### Initialization
$request = ServerRequestFactory::fromGlobals();

### Actions
$path = $request->getUri()->getPath();

if ($path === '/') {
    
    $action = function (ServerRequestInterface $request) {
        $content = 'Hello, ' . ($request->getQueryParams()['name'] ?? 'Guest') . '!';
        
        return new HtmlResponse($content);
    };

} elseif ($path === '/about') {

    $action = function () {
        return new HtmlResponse('I am very simple site;)');
    };

} elseif ($path === '/blog') {
   
    $action = function () {
        return new JsonResponse([
            [
                'id' => 2, 'title' => 'The second post',
            ],
            [
                'id' => 1, 'title' => 'The first post',
            ]
        ]);
    };

} elseif (preg_match('#^/blog/(?P<id>\d+)#i', $path, $matches)) {
    
    $request = $request->withAttribute('id', $matchers['id']);

    $action = function (ServerRequestInterface $request) {
        $maxPastsCount = 2;

        $id = $request->getAttribute('id');

        if ($id > $maxPastsCount) {
            return new JsonResponse(['error' => 'Undefined page'], 404);
        }
    
        if ($id <= $maxPastsCount) {
            return new JsonResponse(['id' => $id, 'title' => 'Post #' . $id]);
        }
    };

} 

if ($action) {
    $response = $action($request);
}

if (! $action) {
    $response = new HtmlResponse('Undefined page', 404);
}


## Postprosessing
$response = $response->withHeader('X-Developer', 'Denis');

$emmiter = new SapiEmitter();
$emmiter->emit($response);
