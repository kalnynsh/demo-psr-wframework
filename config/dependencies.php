<?php

use App\Http\Middleware;
use Aura\Router\RouterContainer;

use Framework\Http\Application;
use Psr\Container\ContainerInterface;
use Framework\Http\Router\RouterInterface;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Pipeline\MiddlewareResolver;

use Laminas\Diactoros\Response;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Laminas\Stratigility\Middleware\NotFoundHandler;
use Laminas\Stratigility\Middleware\ErrorResponseGenerator;

/** @param ContainerInterface $container */

return [
    Application::class => function (ContainerInterface $container) {
        return new Application(
            $container->get(MiddlewareResolver::class),
            $container->get(RouterInterface::class)
        );
    },
    
    RouterContainer::class =>
        function (ContainerInterface $container) {
            return new RouterContainer();
    },

    RouterInterface::class =>
        function (ContainerInterface $container) {
            return new AuraRouterAdapter(
                new RouterContainer()
            );
    },

    MiddlewareResolver::class =>
        function (ContainerInterface $container) {
            return new MiddlewareResolver($container);
    },

    Middleware\BasicAuthMiddleware::class =>
        function  (ContainerInterface $container) {
            return new Middleware\BasicAuthMiddleware(
            $container->get('config')['users']
        );
    },

    ErrorHandler::class =>
        function  (ContainerInterface $container) {
            return new ErrorHandler(
                function () {
                    return new Response();
                }, 
                new ErrorResponseGenerator(
                    $container->get('config')['debug']
                )
            );
        },
    
    Middleware\ProfilerMiddleware::class =>
        function (ContainerInterface $container) {
            return new Middleware\ProfilerMiddleware();
    }, 

    Middleware\CredentialsMiddleware::class =>
        function (ContainerInterface $container) {
            return new Middleware\CredentialsMiddleware();
    },
    
    Framework\Http\Middleware\DispatcherMiddleware::class,
        function (ContainerInterface $container) {
            return new Framework\Http\Middleware\DispatcherMiddleware();
    },
    NotFoundHandler::class =>
        function (ContainerInterface $container) {
            return new NotFoundHandler(function () {
                return new Response();
            });
    },
];
