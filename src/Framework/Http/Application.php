<?php

namespace Framework\Http;

use Psr\Http\Message\ResponseInterface;
use Laminas\Stratigility\MiddlewarePipe;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\RouteDto;
use Framework\Http\Router\RouterInterface;
use Laminas\Stratigility\MiddlewarePipeInterface;

class Application
{
    private MiddlewareResolver       $resolver;
    private MiddlewarePipeInterface  $middlewarePipe;
    private RouterInterface          $router;

    public function __construct(
        MiddlewareResolver $resolver,
        RouterInterface    $router    
    )
    {
        $this->middlewarePipe = $this->getMiddlewarePipe();
        $this->resolver = $resolver;
        $this->router   = $router;       
    }

    /** @param MiddlewareInterface|class-string $middleware */
    public function pipe($middleware): void
    {
        $this
            ->middlewarePipe
            ->pipe(
                $this->resolver->resolve($middleware)
            );
    }

    public function run(
        ServerRequestInterface $request
    ): ResponseInterface
    {
        return $this
            ->middlewarePipe
            ->handle($request);
    }

    public function any(
        string $name, 
        string $path, 
        mixed $handler, 
        array $options = []
    ): void
    {
        $this->route($name, $path, $handler, $options);
    }

    public function addGetRoute(
        string $name, 
        string $path, 
        mixed $handler,
        array $options = []
    ): void
    {
        $this->route($name, $path, $handler, ['GET'], $options);
    }

    public function addPostRoute(
        string $name, 
        string $path, 
        mixed $handler,
        array $options = []
    ): void
    {
        $this->route($name, $path, $handler, ['POST'], $options);
    }

    public function addPutRoute(
        string $name, 
        string $path, 
        mixed $handler,
        array $options = []
    ): void
    {
        $this->route($name, $path, $handler, ['PUT'], $options);
    }

    public function addPatchRoute(
        string $name, 
        string $path, 
        mixed $handler,
        array $options = []
    ): void
    {
        $this->route($name, $path, $handler, ['PATCH'], $options);
    }

    public function addDeleteRoute(
        string $name, 
        string $path, 
        mixed $handler,
        array $options = []
    ): void
    {
        $this->route($name, $path, $handler, ['DELETE'], $options);
    }

    private function route(
        string $name, 
        string $path, 
        mixed  $handler, 
        array  $methods, 
        array  $options = []
    ): void
    {
        $this->router->addRoute(
            new RouteDto(
                $name, 
                $path, 
                $handler, 
                $methods, 
                $options
            )
        );
    }

    public function getRouter(): RouterInterface
    {
        return $this->router;
    }

    private function getMiddlewarePipe(): MiddlewarePipe
    {
        return new MiddlewarePipe();
    }
}
