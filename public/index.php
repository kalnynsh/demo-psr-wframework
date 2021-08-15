<?php

use App\Http\Action;
use App\Http\Middleware;
use Framework\Http\Application;
use Laminas\Diactoros\Response;
use Aura\Router\RouterContainer;

use Framework\Container\Container;
use function Laminas\Stratigility\path;
use Framework\Http\Router\RouterInterface;
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

$serviceLocator->set(
    MiddlewareResolver::class,
    function (Container $serviceLocator) {
        return new MiddlewareResolver();
    }
);

$serviceLocator->set(
    RouterContainer::class,
    function (Container $serviceLocator) {
        return new RouterContainer();
    }
);

$serviceLocator->set(
    RouterInterface::class,
    function (Container $serviceLocator) {
        return new AuraRouterAdapter(
            $serviceLocator->get(RouterContainer::class)
        );
    }
);

$serviceLocator->set(
    Application::class,

    function (Container $serviceLocator) {
        return new Application(
            $serviceLocator->get(MiddlewareResolver::class),
            $serviceLocator->get(RouterInterface::class)
        );
    }
);

## Initialization

/** @var Application $app */
$app = $serviceLocator->get(Application::class);

$app->addGetRoute('home', '/', Action\Home\IndexAction::class);

$app->addGetRoute('about', '/about', Action\Home\AboutAction::class);

$app->addGetRoute(
    'cabinet', 
    '/cabinet',      
    Action\Home\CabinetAction::class 
);

$app->addGetRoute('blog', '/blog', Action\Blog\IndexAction::class);

$app->addGetRoute(
    'blog_show',
    '/blog/{id}',
    Action\Blog\ShowAction::class,
    [
        'tokens' => ['id' => '\\d+',],
    ]   
);

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

$app->pipe(
    new Framework\Http\Middleware\RouteMiddleware(
    $app->getRouter()
    )
);

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
