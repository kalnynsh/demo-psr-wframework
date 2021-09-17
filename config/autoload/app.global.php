<?php

use App\Http\Middleware;
use App\Http\Action\Blog;
use App\Http\Action\Home;

use Framework\Http\Application;
use Laminas\Diactoros\Response;
use Aura\Router\RouterContainer;
use App\Repository\Post\PostRepository;

use App\DataGenerator\Post\PostGenerator;

use Framework\Template\Twig\TwigRenderer;
use Interop\Container\ContainerInterface;
use Framework\Http\Router\RouterInterface;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Middleware\RouteMiddleware;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Template\TemplateRendererInterface;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Framework\Http\Middleware\DispatcherMiddleware;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\Stratigility\Middleware\NotFoundHandler;
use App\Http\Middleware\BasicAuthMiddlewarePathFactory;
use Laminas\Stratigility\Middleware\ErrorResponseGenerator;
use Laminas\Stratigility\Middleware\PathMiddlewareDecorator;
use Framework\Template\Twig\Extension\CustomRoutingExtension;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;

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

            /** @param string $requestedName */
            Application::class =>
            function (ContainerInterface $container, $requestedName, ?array $options = null) {
                return new Application(
                    $container->get(MiddlewareResolver::class),
                    $container->get(RouterInterface::class)
                );
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

            PathMiddlewareDecorator::class => BasicAuthMiddlewarePathFactory::class,

            CustomRoutingExtension::class =>
            function (ContainerInterface $container, $requestedName, ?array $options = null) {

                return new CustomRoutingExtension(
                    $container->get(RouterInterface::class)
                );
            },

            \Twig\Environment::class =>
            function (ContainerInterface $container, $requestedName, ?array $options = null) {
                $templateDir = dirname(__DIR__, 2) . '/templates';
                $cacheDir = dirname(__DIR__, 2) . '/var/cache/twig';
                $debug = $container->get('config')['debug'];

                $loader = new \Twig\Loader\FilesystemLoader();
                $loader->addPath($templateDir);

                $environment = new \Twig\Environment(
                    $loader,
                    [
                        'cache' => $debug ? false : $cacheDir,
                        'debug' => $debug,
                        'strict_variables' => $debug,
                        'auto_reload' => $debug,
                    ]
                );

                if ($debug) {
                    $environment->addExtension(new \Twig\Extension\DebugExtension());
                }

                $environment->addExtension(
                    $container->get(CustomRoutingExtension::class)
                );

                return $environment;
            },

            TemplateRendererInterface::class =>
            function (ContainerInterface $container, $requestedName, ?array $options = null) {
                return new TwigRenderer(
                    $container->get(\Twig\Environment::class),
                    '.html.twig'
                );
            },

            Home\IndexAction::class =>
            function (ContainerInterface $container, $requestedName, ?array $options = null) {
                return new Home\IndexAction(
                    $container->get(TemplateRendererInterface::class)
                );
            },

            Home\AboutAction::class =>
            function (ContainerInterface $container, $requestedName, ?array $options = null) {
                return new Home\AboutAction(
                    $container->get(TemplateRendererInterface::class)
                );
            },

            Home\CabinetAction::class =>
            function (ContainerInterface $container, $requestedName, ?array $options = null) {
                return new Home\CabinetAction(
                    $container->get(TemplateRendererInterface::class)
                );
            },

            Blog\IndexAction::class =>
            function (ContainerInterface $container, $requestedName, ?array $options = null) {
                return new  Blog\IndexAction(
                    $container->get(PostRepository::class),
                    $container->get(TemplateRendererInterface::class)
                );
            },

            Blog\ShowAction::class =>
            function (ContainerInterface $container, $requestedName, ?array $options = null) {
                return new Blog\ShowAction(
                    $container->get(PostRepository::class),
                    $container->get(TemplateRendererInterface::class)
                );
            },

            PostRepository::class =>
            function (ContainerInterface $container, $requestedName, ?array $options = null) {
                return new PostRepository(
                    $container->get(PostGenerator::class)
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
