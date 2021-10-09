<?php

namespace Infrastructure\Framework\Http\Middleware\Resolver;

use Psr\Container\ContainerInterface;
use Framework\Http\Pipeline\MiddlewareResolver;

class MiddlewareResolverFactory
{
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        ?array $options = null
    ) {
        return new MiddlewareResolver($container);
    }
}
