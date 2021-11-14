<?php

namespace Infrastructure\App\Http\Middleware\Response;

use App\Http\Middleware\EmptyResponseMiddleware;
use Framework\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class EmptyResponseMiddlewareFactory
{
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        ?array $options = null
    ) {
        return new EmptyResponseMiddleware(
            $container->get(TemplateRendererInterface::class)
        );
    }
}
