<?php

namespace Infrastructure\Framework\Template\Extension;

use Psr\Container\ContainerInterface;
use Framework\Http\Router\RouterInterface;
use Framework\Template\Twig\Extension\CustomRoutingExtension;

class CustomRoutingExtensionFactory
{
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        ?array $options = null
    ) {
        return new CustomRoutingExtension(
            $container->get(RouterInterface::class)
        );
    }
}
