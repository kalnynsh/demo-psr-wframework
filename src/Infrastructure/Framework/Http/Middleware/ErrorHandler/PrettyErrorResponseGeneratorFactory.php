<?php

namespace Infrastructure\Framework\Http\Middleware\ErrorHandler;

use Laminas\Diactoros\Response;
use Psr\Container\ContainerInterface;
use Framework\Template\TemplateRendererInterface;

class PrettyErrorResponseGeneratorFactory
{
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        ?array $options = null
    ) {
        return new PrettyErrorResponseGenerator(
            $container->get(TemplateRendererInterface::class),
            $container->get(Response::class),
            [
                '403'   => 'error/403',
                '404'   => 'error/404',
                'error' => 'error/error',
            ]
        );
    }
}
