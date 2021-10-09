<?php

namespace Infrastructure\Framework\Http\Middleware\BasicAuth;

use Laminas\Diactoros\Response;
use Psr\Container\ContainerInterface;
use App\Http\Middleware\BasicAuthMiddleware;

class BasicAuthMiddlewareFactory
{
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        ?array $options = null
    ): object {
        return new BasicAuthMiddleware(
            $container->get('config')['auth']['users'],
            new Response()
        );
    }
}
