<?php

use App\Http\Middleware;
use App\Http\Action\Home;

use  App\Http\Action\Blog;
use Framework\Http\Application;

use Laminas\Diactoros\Response;
use Aura\Router\RouterContainer;

use Interop\Container\ContainerInterface;
use Framework\Http\Router\RouterInterface;

use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Pipeline\MiddlewareResolver;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\Stratigility\Middleware\NotFoundHandler;
use App\Http\Middleware\BasicAuthMiddlewarePathFactory;
use Framework\Http\Middleware\RouteMiddleware;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Laminas\Stratigility\Middleware\ErrorResponseGenerator;
use Laminas\Stratigility\Middleware\PathMiddlewareDecorator;


return [
    'dependencies' => [

        'abstract_factories' => [
            ReflectionBasedAbstractFactory::class,
        ],

        'factories' => [
            Home\IndexAction::class => InvokableFactory::class,
            Home\CabinetAction::class => InvokableFactory::class,
            Home\AboutAction::class => InvokableFactory::class,
            Blog\IndexAction::class => InvokableFactory::class,
            Blog\ShowAction::class => InvokableFactory::class,
            Response::class => InvokableFactory::class,
            Middleware\ProfilerMiddleware::class => InvokableFactory::class,
            Middleware\CredentialsMiddleware::class => InvokableFactory::class,
            Framework\Http\Middleware\DispatcherMiddleware::class => InvokableFactory::class,

            /** @param string $requestedName */
            Application::class =>
            function (ContainerInterface $container, $requestedName, ?array $options = null) {
                return new Application(
                    $container->get(MiddlewareResolver::class),
                    $container->get(RouterInterface::class)
                );
            },

            RouterContainer::class =>
            function (ContainerInterface $container, $requestedName, ?array $options = null) {
                return new RouterContainer();
            },

            RouterInterface::class =>
            function (ContainerInterface $container, $requestedName, ?array $options = null) {
                /** @var RouterContainer $dependency */
                $dependency = $container->get(RouterContainer::class);

                return new AuraRouterAdapter($dependency);
            },

            RouteMiddleware::class =>
            function (ContainerInterface $container, $requestedName, ?array $options = null) {
                /** @var RouterInterface $router */
                $router = $container->get(RouterInterface::class);

                return new RouteMiddleware($router);
            },

            MiddlewareResolver::class =>
            function (ContainerInterface $container, $requestedName, ?array $options = null) {
                    return new MiddlewareResolver($container);
            },

            ErrorResponseGenerator::class =>
            function (ContainerInterface $container, $requestedName, ?array $options = null) {
                $isDebug = $container->get('config')['debug'];

                if (\is_array($isDebug)) {
                    $isDebug = $isDebug[count($isDebug) - 1];
                }

                return new ErrorResponseGenerator($isDebug);
            },

            ErrorHandler::class =>
            function (ContainerInterface $container, $requestedName, ?array $options = null) {
                return new ErrorHandler(
                    function () use ($container) {
                        return $container->get(Response::class);
                    },
                    $container->get(ErrorResponseGenerator::class)
                );
            },

            PathMiddlewareDecorator::class => BasicAuthMiddlewarePathFactory::class,

            NotFoundHandler::class =>
            function (ContainerInterface $container, $requestedName, ?array $options = null) {
                    return new NotFoundHandler(function () use ($container) {
                        return $container->get(Response::class);
                    });
            },
        ],
    ],

    'debug' => false,
];
