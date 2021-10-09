<?php

namespace Infrastructure\Framework\Http\Middleware\BasicAuth;

use Psr\Container\ContainerInterface;
use App\Http\Middleware\BasicAuthMiddleware;
use Laminas\Stratigility\Middleware\PathMiddlewareDecorator;

class BasicAuthMiddlewarePathFactory
{
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        ?array $options = null
    ): object {
        /** @var BasicAuthMiddleware $basicAuthMiddleware */
        $basicAuthMiddleware = $container->get(BasicAuthMiddleware::class);
        $path = '/cabinet';

        return new PathMiddlewareDecorator(
            $path,
            $basicAuthMiddleware
        );
    }
}
