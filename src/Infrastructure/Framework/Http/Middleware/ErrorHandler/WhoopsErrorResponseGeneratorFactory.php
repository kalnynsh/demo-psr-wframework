<?php

namespace Infrastructure\Framework\Http\Middleware\ErrorHandler;

use Laminas\Diactoros\Response;
use Psr\Container\ContainerInterface;
use Framework\Http\Middleware\ErrorHandler\WhoopsErrorResponseGenerator;

class WhoopsErrorResponseGeneratorFactory
{
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        ?array $options = null
    ) {
        return new WhoopsErrorResponseGenerator(
            $container->get(\Whoops\RunInterface::class),
            $container->get(Response::class)
        );
    }
}
