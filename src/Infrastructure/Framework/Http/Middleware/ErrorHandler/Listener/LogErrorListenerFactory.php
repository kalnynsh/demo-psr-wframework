<?php

namespace Infrastructure\Framework\Http\Middleware\ErrorHandler\Listener;

use Psr\Log\LoggerInterface;
use Psr\Container\ContainerInterface;
use Infrastructure\Framework\Http\Middleware\ErrorHandler\Listener\LogErrorListener;

class LogErrorListenerFactory
{
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        ?array $options = null
    ) {
        return new LogErrorListener(
            $container->get(LoggerInterface::class)
        );
    }
}
