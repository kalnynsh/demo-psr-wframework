<?php

use App\Http\Action;
use Framework\Http\ActionResolver;
use Framework\Http\Router\RouteCollection;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\SimpleRouter;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

session_start();

### Initialization
$routes = new RouteCollection();

$routes->get('home', '/', Action\Home\IndexAction::class);

$routes->get('about', '/about', Action\Home\AboutAction::class);

$routes->get('blog', '/blog', Action\Blog\IndexAction::class);

$routes->get(
    'blog_show',
    '/blog/{id}',
    Action\Blog\ShowAction::class,
    ['id' => '\d+']
);

$router = new SimpleRouter($routes);
$resolver = new ActionResolver();

# Running
$request = ServerRequestFactory::fromGlobals();

try {
    $result = $router->match($request);

    foreach ($result->getAttributes() as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }


    $handler = $result->getHandler();

    /** @var callable $action */
    $action = $resolver->resolve($handler);
    $response = $action($request);
} catch (RequestNotMatchedException $exc) {
    $response = new HtmlResponse('Undefined page', 404);
}

## Postprosessing

$response = $response->withHeader('X-Developer', 'Denis');

## Sending

$emmiter = new SapiEmitter();
$emmiter->emit($response);
