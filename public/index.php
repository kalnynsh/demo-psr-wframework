<?php

use App\Http\Action;
use App\Http\Middleware;
use Framework\Http\Application;
use Laminas\Diactoros\Response;
use Aura\Router\RouterContainer;
use function Laminas\Stratigility\path;
use Laminas\Diactoros\ServerRequestFactory;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Pipeline\MiddlewareResolver;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Laminas\Stratigility\Middleware\NotFoundHandler;
use Laminas\Stratigility\Middleware\ErrorResponseGenerator;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

session_start();

### Initialization
$usersParams = [
    'users' => [
        'admin' => 'adminPassword',
    ]
];

$params = [
    'debug' => true,
];

$auraRouterContainer = new RouterContainer();
$routes = $auraRouterContainer->getMap();

$routes->get('home', '/', Action\Home\IndexAction::class);

$routes->get('about', '/about', Action\Home\AboutAction::class);

$routes->get(
    'cabinet', 
    '/cabinet',      
    Action\Home\CabinetAction::class 
);

$routes->get('blog', '/blog', Action\Blog\IndexAction::class);

$routes->get(
    'blog_show',
    '/blog/{id}',
    Action\Blog\ShowAction::class    
)->tokens(['id' => '\\d+']);

$router = new AuraRouterAdapter($auraRouterContainer);
$resolver = new MiddlewareResolver();
$app = new Application($resolver);

// Laminas ErrorHandler
$app->pipe(
    new ErrorHandler(
        function () {
            return new Response();
        }, 
        new ErrorResponseGenerator($params['debug'])
    )
);

// Own ErrorHandlerMiddleware
// $app->pipe(new Middleware\ErrorHandlerMiddleware($params['debug']));

/* Global ProfileMiddleware */
$app->pipe(Middleware\ProfilerMiddleware::class);
$app->pipe(Middleware\CredentialsMiddleware::class);

$app->pipe(new Framework\Http\Middleware\RouteMiddleware($router));

$app->pipe(path(
    '/cabinet', 
    new Middleware\BasicAuthMiddleware($usersParams['users'])
));

$app->pipe(new Framework\Http\Middleware\DispatcherMiddleware());

$app->pipe(new NotFoundHandler(function () {
    return new Response();
}));

# Running
$request = ServerRequestFactory::fromGlobals();
$response = $app->run($request);

## Sending
$emmiter = new SapiEmitter();
$emmiter->emit($response);
