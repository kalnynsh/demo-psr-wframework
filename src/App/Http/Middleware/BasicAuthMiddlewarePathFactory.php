<?php

namespace App\Http\Middleware;

use Interop\Container\ContainerInterface;
use App\Http\Middleware\BasicAuthMiddleware;
use Laminas\Stratigility\Middleware\PathMiddlewareDecorator;

class BasicAuthMiddlewarePathFactory
{
    public function __invoke(
        ContainerInterface $container,
        string $requestedName
    ): object
    {
        /** @var BasicAuthMiddleware $basicAuthMiddleware */
        $basicAuthMiddleware = $container->get(BasicAuthMiddleware::class);
        $path = '/cabinet';

        return new PathMiddlewareDecorator(
            $path,
            $basicAuthMiddleware
        );
    }
}
