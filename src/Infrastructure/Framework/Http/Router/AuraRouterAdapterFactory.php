<?php

namespace Infrastructure\Framework\Http\Router;

use Aura\Router\RouterContainer;
use Psr\Container\ContainerInterface;
use Framework\Http\Router\AuraRouterAdapter;

class AuraRouterAdapterFactory
{
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        ?array $options = null
    ) {
        return new AuraRouterAdapter(
            $container->get(RouterContainer::class)
        );
    }
}
