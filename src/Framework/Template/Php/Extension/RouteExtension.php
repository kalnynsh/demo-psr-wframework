<?php

namespace Framework\Template\Php\Extension;

use Framework\Template\Php\Extension;
use Framework\Http\Router\RouterInterface;
use Framework\Template\Php\SimpleFunction;

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
            $this->getSimpleFunction(
                'path',
                [$this, 'generatePath']
            ),
        ];
    }

    public function generatePath(string $name, array $params = []): string|false
    {
        return $this->router->generate($name, $params);
    }

    private function getSimpleFunction(
        string $name,
        callable $callback,
        bool $needRendering = false
    ): SimpleFunction {
        return new SimpleFunction(
            $name,
            $callback,
            $needRendering
        );
    }
}
