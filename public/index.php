<?php

use App\Http\Action;
use Framework\Http\Router\Router;
use Framework\Http\Router\RouteCollection;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Framework\Http\Router\Exception\RequestNotMatchedException;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

session_start();

### Initialization

$routes = new RouteCollection();

$routes->get('home', '/', new Action\Home\IndexAction());

$routes->get('about', '/about', new Action\Home\AboutAction());

$routes->get('blog', '/blog', new Action\Blog\IndexAction());

$routes->get(
    'blog_show',
    '/blog/{id}', 
    new Action\Blog\ShowAction(), 
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
