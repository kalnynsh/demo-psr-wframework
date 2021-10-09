<?php

namespace Infrastructure\Framework\Http\Middleware\Route;

use Psr\Container\ContainerInterface;
use Framework\Http\Router\RouterInterface;
use Framework\Http\Middleware\RouteMiddleware;

class RouteMiddlewareFactory
{
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        ?array $options = null
    ) {
        return new RouteMiddleware(
            $container->get(RouterInterface::class)
        );
    }
}
