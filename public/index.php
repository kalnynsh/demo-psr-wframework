<?php

use App\Http\Action;
use App\Http\Middleware;
use Aura\Router\RouterContainer;
use Framework\Http\Application;
use Framework\Http\MiddlewareResolver;
use Framework\Http\Router\AuraRouterAdapter;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

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
$app = new Application($resolver, new Middleware\NotFoundHandler());

$app->pipe(new Middleware\ErrorHandlerMiddleware($params['debug']));

/** Global ProfileMiddleware */
$app->pipe(Middleware\ProfilerMiddleware::class);
$app->pipe(Middleware\CredentialsMiddleware::class);
$app->pipe(new \Framework\Http\Middleware\RouteMiddleware($router, $resolver));

# Running
$request = ServerRequestFactory::fromGlobals();
$response = $app->run($request);

## Sending

$emmiter = new SapiEmitter();
$emmiter->emit($response);
