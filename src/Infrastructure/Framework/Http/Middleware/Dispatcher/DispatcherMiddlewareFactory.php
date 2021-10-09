<?php

namespace Infrastructure\Framework\Http\Middleware\Dispatcher;

use Psr\Container\ContainerInterface;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Middleware\DispatcherMiddleware;

class DispatcherMiddlewareFactory
{
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        ?array $options = null
    ) {
        return new DispatcherMiddleware(
            $container->get(MiddlewareResolver::class)
        );
    }
}
