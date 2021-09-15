<?php

namespace Framework\Template\Php\Extension;

use Framework\Template\Php\Extension;
use Framework\Http\Router\RouterInterface;

class RouteExtension extends Extension
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function getFunctions(): array
    {
        return [
            'path' => [$this, 'generatePath'],
        ];
    }

    public function generatePath(string $name, array $params = []): string|false
    {
        return $this->router->generate($name, $params);
    }
}
