<?php

namespace Framework\Http;

// use Framework\Http\Pipeline\Pipeline;
use Psr\Http\Message\ResponseInterface;
use Laminas\Stratigility\MiddlewarePipe;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Http\Pipeline\MiddlewareResolver;
use Laminas\Stratigility\MiddlewarePipeInterface;

class Application
{
    private MiddlewareResolver       $resolver;
    private MiddlewarePipeInterface  $middlewarePipe;

    public function __construct(MiddlewareResolver $resolver)
    {
        $this->middlewarePipe = new MiddlewarePipe();
        $this->resolver = $resolver;        
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
}
