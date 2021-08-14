<?php

use App\Http\Action;
use App\Http\Middleware;
use Framework\Http\Application;
use Laminas\Diactoros\Response;
use Aura\Router\RouterContainer;

use Laminas\Diactoros\ServerRequestFactory;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Pipeline\MiddlewareResolver;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Laminas\Stratigility\Middleware\NotFoundHandler;
use Laminas\Stratigility\Middleware\ErrorResponseGenerator;
use Framework\Container\Container;

use function Laminas\Stratigility\path;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

session_start();



### Initialization
$serviceLocator = new Container();
$serviceLocator->set(
    'config',
    [
        'debug' => true,
        'users' => [
            'admin' => 'supassword',
        ],
    ]
);

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
/** @var bool $isDebug */
$isDebugMode = $serviceLocator->get('config')['debug'];

$app->pipe(
    new ErrorHandler(
        function () {
            return new Response();
        }, 
        new ErrorResponseGenerator($isDebugMode)
    )
);

// Own ErrorHandlerMiddleware
// $app->pipe(new Middleware\ErrorHandlerMiddleware($isDebugMode));

/* Global ProfileMiddleware */
$app->pipe(Middleware\ProfilerMiddleware::class);
$app->pipe(Middleware\CredentialsMiddleware::class);

$app->pipe(new Framework\Http\Middleware\RouteMiddleware($router));

/** @var array $users */
$users = $serviceLocator->get('config')['users'];

$app->pipe(path(
    '/cabinet', 
    new Middleware\BasicAuthMiddleware($users)
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
