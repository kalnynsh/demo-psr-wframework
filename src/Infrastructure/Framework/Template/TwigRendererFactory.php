<?php

namespace Infrastructure\Framework\Template;

use Psr\Container\ContainerInterface;
use Framework\Template\Twig\TwigRenderer;

class TwigRendererFactory
{
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        ?array $options = null
    ) {
        return new TwigRenderer(
            $container->get(\Twig\Environment::class),
            $container->get('config')['templates']['file_extension']
        );
    }
}
