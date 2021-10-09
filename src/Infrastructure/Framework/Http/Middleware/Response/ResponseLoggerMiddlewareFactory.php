<?php

namespace Infrastructure\Framework\Http\Middleware\Response;

use Psr\Log\LoggerInterface;
use Psr\Container\ContainerInterface;
use Infrastructure\Framework\Http\Middleware\Response\ResponseLoggerMiddleware;

class ResponseLoggerMiddlewareFactory
{
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        ?array $options = null
    ) {
        return new ResponseLoggerMiddleware(
            $container->get(LoggerInterface::class)
        );
    }
}
