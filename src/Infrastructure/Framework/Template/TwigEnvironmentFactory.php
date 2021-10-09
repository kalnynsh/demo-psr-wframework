<?php

namespace Infrastructure\Framework\Template;

use Psr\Container\ContainerInterface;
use Framework\Template\Twig\Extension\CustomRoutingExtension;

class TwigEnvironmentFactory
{
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        ?array $options = null
    ) {
        /** @var array $twigConfig */
        $twigConfig = $container->get('config')['twig'];

        /** @var bool $debug */
        $debug = $container->get('config')['debug'];

        $loader = new \Twig\Loader\FilesystemLoader();
        $loader->addPath($twigConfig['template_dir']);

        $environment = new \Twig\Environment(
            $loader,
            [
                'cache' => $debug ? false : $twigConfig['cache_dir'],
                'debug' => $debug,
                'strict_variables' => $debug,
                'auto_reload' => $debug,
            ]
        );

        if ($debug) {
            $environment->addExtension(new \Twig\Extension\DebugExtension());
        }

        $environment->addExtension(
            $container->get(CustomRoutingExtension::class)
        );

        foreach ($twigConfig['extensions'] as $extension) {
            $environment->addExtension($container->get($extension));
        }

        return $environment;
    }
}
