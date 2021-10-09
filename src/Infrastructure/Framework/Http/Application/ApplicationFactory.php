<?php

namespace Infrastructure\Framework\Http\Application;

use Framework\Http\Application;
use Psr\Container\ContainerInterface;
use Framework\Http\Router\RouterInterface;
use Framework\Http\Pipeline\MiddlewareResolver;

class ApplicationFactory
{
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        ?array $options = null
    ) {
        return new Application(
            $container->get(MiddlewareResolver::class),
            $container->get(RouterInterface::class)
        );
    }
}
