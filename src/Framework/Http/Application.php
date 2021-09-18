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
use Psr\Http\Server\RequestHandlerInterface;

class Application implements MiddlewarePipeInterface
{
    private MiddlewareResolver       $resolver;
    private MiddlewarePipeInterface  $pipeline;
    private RouterInterface          $router;

    public function __construct(
        MiddlewareResolver $resolver,
        RouterInterface    $router
    ) {
        $this->pipeline = $this->getMiddlewarePipe();
        $this->resolver = $resolver;
        $this->router   = $router;
    }

    /** @param MiddlewareInterface|class-string $middleware */
    public function pipe($middleware): void
    {
        $this
            ->pipeline
            ->pipe(
                $this->resolver->resolve($middleware)
            );
    }

    public function handle(
        ServerRequestInterface $request
    ): ResponseInterface {
        return $this
            ->pipeline
            ->handle($request);
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        return $this
            ->pipeline
            ->process($request, $handler);
    }

    public function any(
        string $name,
        string $path,
        mixed $handler,
        array $options = []
    ): void {
        $this->route($name, $path, $handler, $options);
    }

    public function get(
        string $name,
        string $path,
        mixed $handler,
        array $options = []
    ): void {
        $this->route($name, $path, $handler, ['GET'], $options);
    }

    public function post(
        string $name,
        string $path,
        mixed $handler,
        array $options = []
    ): void {
        $this->route($name, $path, $handler, ['POST'], $options);
    }

    public function put(
        string $name,
        string $path,
        mixed $handler,
        array $options = []
    ): void {
        $this->route($name, $path, $handler, ['PUT'], $options);
    }

    public function patch(
        string $name,
        string $path,
        mixed $handler,
        array $options = []
    ): void {
        $this->route($name, $path, $handler, ['PATCH'], $options);
    }

    public function delete(
        string $name,
        string $path,
        mixed $handler,
        array $options = []
    ): void {
        $this->route($name, $path, $handler, ['DELETE'], $options);
    }

    private function route(
        string $name,
        string $path,
        mixed  $handler,
        array  $methods,
        array  $options = []
    ): void {
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
