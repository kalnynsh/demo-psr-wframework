<?php

namespace Infrastructure\Framework\Http\Middleware\ErrorHandler;

use Psr\Container\ContainerInterface;
use Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGeneratorInterface;
use Infrastructure\Framework\Http\Middleware\ErrorHandler\Listener\LogErrorListener;

class ErrorHandlerMiddlewareFactory
{
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        ?array $options = null
    ) {
        $middleware = new ErrorHandlerMiddleware(
            $container->get(ErrorResponseGeneratorInterface::class),
        );

        $middleware->addListener($container->get(LogErrorListener::class));

        return $middleware;
    }
}
