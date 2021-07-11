<?php

use Framework\Http\Router\Router;
use Framework\Http\Router\RouteCollection;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Framework\Http\Router\Exception\RequestNotMatchedException;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

session_start();

### Initialization

$routes = new RouteCollection();

$routes->get('home', '/', function (ServerRequestInterface $request) {
    $content = 'Hello '
        . ($request->getQueryParams()['name'] ?? 'Guest')
        . '!' ;
    
    return new HtmlResponse($content);
});


$routes->get(
    'about',
    '/about',
    function() {
        return new HtmlResponse('I am the simple about page.');
    }
);

$routes->get(
    'blog',
    '/blog',
    function() {
        return new JsonResponse([
            ['id' => 2, 'title' => 'The second post'],
            ['id' => 1, 'title' => 'The first post'],
        ]);
    }
);

$routes->get(
    'blog_show',
    '/blog/{id}',
    function(ServerRequestInterface $request) {
        $id = $request->getAttribute('id');

        if ($id > 2) {
            return new HtmlResponse('Undefined page', 404);
        }

        return new JsonResponse(
            ['id' => $id, 'title' => 'Post #' . $id],
            );
    },
    ['id' => '\d+']
);

$router = new Router($routes);

# Running

$request = ServerRequestFactory::fromGlobals();

try {
    $result = $router->match($request);

    foreach ($result->getAttributes() as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }

    /** @var callable $action */
    $action = $result->getHandler();
    $response = $action($request);

} catch (RequestNotMatchedException $exc) {
    $response = new HtmlResponse('Undefined page', 404);
}

## Postprosessing

$response = $response->withHeader('X-Developer', 'Denis');

## Sending

$emmiter = new SapiEmitter();
$emmiter->emit($response);
