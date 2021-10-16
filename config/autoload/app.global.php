<?php

use App\Http\Middleware;
use App\Http\Action\Blog;
use App\Http\Action\Home;

use Psr\Log\LoggerInterface;

use Framework\Http\Application;
use Laminas\Diactoros\Response;
use Aura\Router\RouterContainer;
use Psr\Container\ContainerInterface;

use App\Repository\Post\PostRepository;

use App\DataGenerator\Post\PostGenerator;

use App\Console\Command\CacheClearCommand;
use App\Service\FileService\FileManager;
use Framework\Http\Router\RouterInterface;
use Framework\Http\Middleware\RouteMiddleware;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Template\TemplateRendererInterface;
use Framework\Http\Middleware\DispatcherMiddleware;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\Stratigility\Middleware\NotFoundHandler;
use Laminas\Stratigility\Middleware\PathMiddlewareDecorator;
use Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGeneratorInterface;
use Infrastructure\Framework\Http\Middleware\Response\ResponseLoggerMiddleware;
use Infrastructure\Framework\Http\Middleware\ErrorHandler\Listener\LogErrorListener;
use Infrastructure\Framework\Http\Middleware\BasicAuth\BasicAuthMiddlewarePathFactory;
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
            FileManager::class => InvokableFactory::class,

            PostGenerator::class => InvokableFactory::class,
            CacheClearCommand::class => InvokableFactory::class,

            Application::class => Infrastructure\Framework\Http\Application\ApplicationFactory::class,

            ErrorHandlerMiddleware::class =>
                \Infrastructure\Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddlewareFactory::class,

            LogErrorListener::class =>
                \Infrastructure\Framework\Http\Middleware\ErrorHandler\Listener\LogErrorListenerFactory::class,

            ErrorResponseGeneratorInterface::class =>
                \Infrastructure\Framework\Http\Middleware\ErrorHandler\PrettyErrorResponseGeneratorFactory::class,

            PrettyErrorResponseGenerator::class =>
                \Infrastructure\Framework\Http\Middleware\ErrorHandler\PrettyErrorResponseGeneratorFactory::class,

            LoggerInterface::class =>
                \Infrastructure\Framework\Http\Logger\MonologLoggerFactory::class,

            ResponseLoggerMiddleware::class =>
                \Infrastructure\Framework\Http\Middleware\Response\ResponseLoggerMiddlewareFactory::class,

            DispatcherMiddleware::class =>
                \Infrastructure\Framework\Http\Middleware\Dispatcher\DispatcherMiddlewareFactory::class,

            RouterContainer::class => InvokableFactory::class,

            RouterInterface::class => \Infrastructure\Framework\Http\Router\AuraRouterAdapterFactory::class,

            RouteMiddleware::class => \Infrastructure\Framework\Http\Middleware\Route\RouteMiddlewareFactory::class,

            MiddlewareResolver::class =>
                \Infrastructure\Framework\Http\Middleware\Resolver\MiddlewareResolverFactory::class,

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
