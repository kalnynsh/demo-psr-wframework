<?php

use App\Http\Middleware;
use App\Http\Action\Home;
use App\Http\Action\Blog;

use Framework\Http\Application;
use Laminas\Diactoros\Response;
use Aura\Router\RouterContainer;
use Framework\Template\TemplateRenderer;

use Interop\Container\ContainerInterface;
use Framework\Http\Router\RouterInterface;

use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Middleware\RouteMiddleware;
use Framework\Http\Pipeline\MiddlewareResolver;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Framework\Http\Middleware\DispatcherMiddleware;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\Stratigility\Middleware\NotFoundHandler;
use App\Http\Middleware\BasicAuthMiddlewarePathFactory;
use Laminas\Stratigility\Middleware\ErrorResponseGenerator;
use Laminas\Stratigility\Middleware\PathMiddlewareDecorator;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;

return [
    'dependencies' => [

        'abstract_factories' => [
            ReflectionBasedAbstractFactory::class,
        ],

        'factories' => [
            Home\CabinetAction::class => InvokableFactory::class,
            Home\AboutAction::class => InvokableFactory::class,
            Blog\IndexAction::class => InvokableFactory::class,
            Blog\ShowAction::class => InvokableFactory::class,
            Response::class => InvokableFactory::class,
            Middleware\ProfilerMiddleware::class => InvokableFactory::class,
            Middleware\CredentialsMiddleware::class => InvokableFactory::class,

            /** @param string $requestedName */
            Application::class =>
            function (ContainerInterface $container, $requestedName, ?array $options = null) {
                return new Application(
                    $container->get(MiddlewareResolver::class),
                    $container->get(RouterInterface::class)
                );
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

            DispatcherMiddleware::class =>
            function (ContainerInterface $container, $requestedName, ?array $options = null) {
                return new DispatcherMiddleware(
                    $container->get(MiddlewareResolver::class)
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

            PathMiddlewareDecorator::class => BasicAuthMiddlewarePathFactory::class,

            TemplateRenderer::class =>
            function (ContainerInterface $container, $requestedName, ?array $options = null) {
                return new TemplateRenderer(dirname(__DIR__, 2) . '/src/templates');
            },

            Home\IndexAction::class =>
            function (ContainerInterface $container, $requestedName, ?array $options = null) {
                return new Home\IndexAction(
                    $container->get(TemplateRenderer::class)
                );
            },

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
