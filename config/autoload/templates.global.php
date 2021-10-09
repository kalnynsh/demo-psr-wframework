<?php

use Framework\Template\TemplateRendererInterface;
use Infrastructure\Framework\Template\TwigRendererFactory;
use Framework\Template\Twig\Extension\CustomRoutingExtension;
use Infrastructure\Framework\Template\TwigEnvironmentFactory;
use Infrastructure\Framework\Template\Extension\CustomRoutingExtensionFactory;

return [
    'dependencies' => [
        'factories' => [
            CustomRoutingExtension::class => CustomRoutingExtensionFactory::class,

            \Twig\Environment::class => TwigEnvironmentFactory::class,

            TemplateRendererInterface::class => TwigRendererFactory::class,
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
