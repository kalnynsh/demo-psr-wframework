<?php

use App\Http\Middleware;
use App\Http\Action\Blog;
use App\Http\Action\Home;

use Framework\Http\Application;

use Laminas\Diactoros\Response;
use Aura\Router\RouterContainer;
use Psr\Container\ContainerInterface;
use App\Repository\Post\PostRepository;

use App\DataGenerator\Post\PostGenerator;

use Framework\Http\Router\RouterInterface;

use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Middleware\RouteMiddleware;
use Whoops\RunInterface as WhoopsRunInterface;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Template\TemplateRendererInterface;
use Framework\Http\Middleware\DispatcherMiddleware;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\Stratigility\Middleware\NotFoundHandler;
use App\Http\Middleware\BasicAuthMiddlewarePathFactory;
use Laminas\Stratigility\Middleware\PathMiddlewareDecorator;
use Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use Framework\Http\Middleware\ErrorHandler\WhoopsErrorResponseGenerator;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGeneratorInterface;
use Infrastructure\Framework\Http\Middleware\ErrorHandler\PrettyErrorResponseGenerator;

return [
    'dependencies' => [

        'abstract_factories' => [
            ReflectionBasedAbstractFactory::class,
        ],

        'factories' => [
            Response::class => InvokableFactory::class,
            Middleware\ProfilerMiddleware::class => InvokableFactory::class,
            Middleware\CredentialsMiddleware::class => InvokableFactory::class,
            PostGenerator::class => InvokableFactory::class,

            Application::class =>
            function (ContainerInterface $container, string $requestedName, ?array $options = null) {
                return new Application(
                    $container->get(MiddlewareResolver::class),
                    $container->get(RouterInterface::class)
                );
            },

            ErrorHandlerMiddleware::class =>
            function (ContainerInterface $container, string $requestedName, ?array $options = null) {
                return new ErrorHandlerMiddleware(
                    $container->get(ErrorResponseGeneratorInterface::class)
                );
            },

            ErrorResponseGeneratorInterface::class =>
            function (ContainerInterface $container, string $requestedName, ?array $options = null) {
                if ($container->get('config')['debug']) {
                    return new WhoopsErrorResponseGenerator(
                        $container->get(WhoopsRunInterface::class),
                        new Response()
                    );
                }

                return new PrettyErrorResponseGenerator(
                    $container->get(TemplateRendererInterface::class),
                    new Response(),
                    [
                        '403'   => 'error/403',
                        '404'   => 'error/404',
                        'error' => 'error/error',
                    ]
                );
            },

            WhoopsRunInterface::class =>
            function (ContainerInterface $container, string $requestedName, ?array $options = null) {
                $whoops = new \Whoops\Run();

                $whoops->writeToOutput(false);
                $whoops->allowQuit(false);
                $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());

                $whoops->register();

                return $whoops;
            },


            DispatcherMiddleware::class =>
            function (ContainerInterface $container, string $requestedName, ?array $options = null) {
                return new DispatcherMiddleware(
                    $container->get(MiddlewareResolver::class)
                );
            },

            RouterContainer::class =>
            function (ContainerInterface $container, string $requestedName, ?array $options = null) {
                return new RouterContainer();
            },

            RouterInterface::class =>
            function (ContainerInterface $container, string $requestedName, ?array $options = null) {
                /** @var RouterContainer $dependency */
                $dependency = $container->get(RouterContainer::class);

                return new AuraRouterAdapter($dependency);
            },

            RouteMiddleware::class =>
            function (ContainerInterface $container, string $requestedName, ?array $options = null) {
                /** @var RouterInterface $router */
                $router = $container->get(RouterInterface::class);

                return new RouteMiddleware($router);
            },

            MiddlewareResolver::class =>
            function (ContainerInterface $container, string $requestedName, ?array $options = null) {
                    return new MiddlewareResolver($container);
            },

            PathMiddlewareDecorator::class => BasicAuthMiddlewarePathFactory::class,

            Home\IndexAction::class =>
            function (ContainerInterface $container, string $requestedName, ?array $options = null) {
                return new Home\IndexAction(
                    $container->get(TemplateRendererInterface::class)
                );
            },

            Home\AboutAction::class =>
            function (ContainerInterface $container, string $requestedName, ?array $options = null) {
                return new Home\AboutAction(
                    $container->get(TemplateRendererInterface::class)
                );
            },

            Home\CabinetAction::class =>
            function (ContainerInterface $container, string $requestedName, ?array $options = null) {
                return new Home\CabinetAction(
                    $container->get(TemplateRendererInterface::class)
                );
            },

            Blog\IndexAction::class =>
            function (ContainerInterface $container, string $requestedName, ?array $options = null) {
                return new  Blog\IndexAction(
                    $container->get(PostRepository::class),
                    $container->get(TemplateRendererInterface::class)
                );
            },

            Blog\ShowAction::class =>
            function (ContainerInterface $container, string $requestedName, ?array $options = null) {
                return new Blog\ShowAction(
                    $container->get(PostRepository::class),
                    $container->get(TemplateRendererInterface::class)
                );
            },

            PostRepository::class =>
            function (ContainerInterface $container, string $requestedName, ?array $options = null) {
                return new PostRepository(
                    $container->get(PostGenerator::class)
                );
            },

            NotFoundHandler::class =>
            function (ContainerInterface $container, string $requestedName, ?array $options = null) {
                    return new NotFoundHandler(function () use ($container) {
                        return $container->get(Response::class);
                    });
            },
        ],
    ],

    'debug' => false,
];
