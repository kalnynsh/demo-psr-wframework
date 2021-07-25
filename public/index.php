<?php

use App\Http\Action;
use App\Http\Middleware;
use Aura\Router\RouterContainer;
use Framework\Http\Application;
use Framework\Http\MiddlewareResolver;
use Framework\Http\Router\AuraRouterAdapter;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Framework\Http\Router\Exception\RequestNotMatchedException;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

session_start();

### Initialization
$usersParams = [
    'users' => [
        'admin' => 'adminPassword',
    ]
];

$auraRouterContainer = new RouterContainer();
$routes = $auraRouterContainer->getMap();

$routes->get('home', '/', Action\Home\IndexAction::class);

$routes->get('about', '/about', Action\Home\AboutAction::class);

$routes->get(
    'cabinet', 
    '/cabinet',
    [
        Middleware\ProfilerMiddleware::class,
        new Middleware\BasicAuthMiddleware($usersParams['users']),
        Action\Home\CabinetAction::class,
    ]    
);

$routes->get('blog', '/blog', Action\Blog\IndexAction::class);

$routes->get(
    'blog_show',
    '/blog/{id}',
    Action\Blog\ShowAction::class    
)->tokens(['id' => '\d+']);

$router = new AuraRouterAdapter($auraRouterContainer);
$resolver = new MiddlewareResolver();
$app = new Application($resolver);

/** Global ProfileMiddleware */
$app->pipe(Middleware\ProfilerMiddleware::class);

# Running
$request = ServerRequestFactory::fromGlobals();

try {
    $result = $router->match($request);

    foreach ($result->getAttributes() as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }

    $app->pipe($result->getHandler());
    
} catch (RequestNotMatchedException $exception) { }

$response = $app($request, new Middleware\NotFoundHandler());

## Postprosessing

$response = $response->withHeader('X-Developer', 'Denis');

## Sending

$emmiter = new SapiEmitter();
$emmiter->emit($response);
