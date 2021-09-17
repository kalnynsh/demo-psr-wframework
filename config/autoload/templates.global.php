<?php

use Psr\Container\ContainerInterface;
use Framework\Template\Twig\TwigRenderer;
use Framework\Http\Router\RouterInterface;
use Framework\Template\TemplateRendererInterface;
use Framework\Template\Twig\Extension\CustomRoutingExtension;

return [
    'dependencies' => [
        'factories' => [
            CustomRoutingExtension::class =>
            function (ContainerInterface $container, $requestedName, ?array $options = null) {

                return new CustomRoutingExtension(
                    $container->get(RouterInterface::class)
                );
            },

            \Twig\Environment::class =>
            function (ContainerInterface $container, $requestedName, ?array $options = null) {
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

                return $environment;
            },

            TemplateRendererInterface::class =>
            function (ContainerInterface $container, $requestedName, ?array $options = null) {
                return new TwigRenderer(
                    $container->get(\Twig\Environment::class),
                    $container->get('config')['templates']['file_extension']
                );
            },
        ],
    ],

    'templates' => [
        'file_extension' => '.html.twig',
    ],

    'twig' => [
        'template_dir' => dirname(__DIR__, 2) . '/templates',
        'cache_dir' => dirname(__DIR__, 2) . '/var/cache/twig',
        'extensions' => [],
    ],
];
