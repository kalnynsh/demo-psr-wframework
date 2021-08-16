<?php

use App\Http\Middleware;
use Aura\Router\RouterContainer;

use Framework\Http\Application;
use Framework\Container\Container;
use Framework\Http\Router\RouterInterface;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Pipeline\MiddlewareResolver;

use Laminas\Diactoros\Response;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Laminas\Stratigility\Middleware\NotFoundHandler;
use Laminas\Stratigility\Middleware\ErrorResponseGenerator;

/** @var Container $serviceLocator */

$serviceLocator->set(
    MiddlewareResolver::class,
    function (Container $serviceLocator) {
        return new MiddlewareResolver($serviceLocator);
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
    Application::class,

    function (Container $serviceLocator) {
        return new Application(
            $serviceLocator->get(MiddlewareResolver::class),
            $serviceLocator->get(RouterInterface::class)
        );
    }
);
