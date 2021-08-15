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

## Configuration
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

$serviceLocator->set(
    Middleware\BasicAuthMiddleware::class,
    function  (Container $serviceLocator) {
        return new Middleware\BasicAuthMiddleware(
            $serviceLocator->get('config')['users']
        );
    }
);

// Laminas ErrorHandler
$serviceLocator->set(
    ErrorHandler::class,
    function  (Container $serviceLocator) {
        return new ErrorHandler(
            function () {
        return new Response();
            }, 
            new ErrorResponseGenerator(
                $serviceLocator->get('config')['debug']
            )
        );
    }
);

$serviceLocator->set(
    Middleware\ProfilerMiddleware::class,
    function (Container $serviceLocator) {
        return new Middleware\ProfilerMiddleware();
    }
);

$serviceLocator->set(
    Middleware\CredentialsMiddleware::class,
    function (Container $serviceLocator) {
        return new Middleware\CredentialsMiddleware();
    }
);

$serviceLocator->set(
    Framework\Http\Middleware\DispatcherMiddleware::class,
    function (Container $serviceLocator) {
        return new Framework\Http\Middleware\DispatcherMiddleware();
    }
);

$serviceLocator->set(
    NotFoundHandler::class,
    function (Container $serviceLocator) {
        return new NotFoundHandler(function () {
            return new Response();
        });
    }
);

## Initialization
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
    $serviceLocator->get(ErrorHandler::class)
);

// Global ProfileMiddleware 

// Own ErrorHandlerMiddleware
// $app->pipe(new Middleware\ErrorHandlerMiddleware($isDebugMode));

$app->pipe(
    $serviceLocator->get(Middleware\ProfilerMiddleware::class)
);

$app->pipe(
    $serviceLocator->get(Middleware\CredentialsMiddleware::class)
);

$app->pipe(new Framework\Http\Middleware\RouteMiddleware($router));

$app->pipe(path(
    '/cabinet', 
    $serviceLocator->get(Middleware\BasicAuthMiddleware::class)
));

$app->pipe(
    $serviceLocator->get(Framework\Http\Middleware\DispatcherMiddleware::class)
);

$app->pipe(
    $serviceLocator->get(NotFoundHandler::class)
);

# Running
$request = ServerRequestFactory::fromGlobals();
$response = $app->run($request);

## Sending
$emmiter = new SapiEmitter();
$emmiter->emit($response);
