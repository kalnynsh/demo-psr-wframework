<?php

namespace Infrastructure\Framework\Http\Whoops;

use Psr\Container\ContainerInterface;

class WhoopsRunFactory
{
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        ?array $options = null
    ) {
        $whoops = new \Whoops\Run();

        $whoops->writeToOutput(false);
        $whoops->allowQuit(false);
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());

        $whoops->register();

        return $whoops;
    }
}
