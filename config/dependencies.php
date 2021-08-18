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

/** @param Container $serviceLocator */

return [
    Application::class => function (Container $serviceLocator) {
        return new Application(
            $serviceLocator->get(MiddlewareResolver::class),
            $serviceLocator->get(RouterInterface::class)
        );
    },
    
    RouterContainer::class =>
        function (Container $serviceLocator) {
            return new RouterContainer();
    },

    RouterInterface::class =>
        function (Container $serviceLocator) {
            return new AuraRouterAdapter(
                new RouterContainer()
            );
    },

    MiddlewareResolver::class =>
        function (Container $serviceLocator) {
            return new MiddlewareResolver($serviceLocator);
    },

    Middleware\BasicAuthMiddleware::class =>
        function  (Container $serviceLocator) {
            return new Middleware\BasicAuthMiddleware(
            $serviceLocator->get('config')['users']
        );
    },

    ErrorHandler::class =>
        function  (Container $serviceLocator) {
            return new ErrorHandler(
                function () {
                    return new Response();
                }, 
                new ErrorResponseGenerator(
                    $serviceLocator->get('config')['debug']
                )
            );
        },
    
    Middleware\ProfilerMiddleware::class =>
        function (Container $serviceLocator) {
            return new Middleware\ProfilerMiddleware();
    }, 

    Middleware\CredentialsMiddleware::class =>
        function (Container $serviceLocator) {
            return new Middleware\CredentialsMiddleware();
    },
    
    Framework\Http\Middleware\DispatcherMiddleware::class,
        function (Container $serviceLocator) {
            return new Framework\Http\Middleware\DispatcherMiddleware();
    },
    NotFoundHandler::class =>
        function (Container $serviceLocator) {
            return new NotFoundHandler(function () {
                return new Response();
            });
    },
];
