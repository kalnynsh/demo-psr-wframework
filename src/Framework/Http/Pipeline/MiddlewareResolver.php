<?php

namespace Framework\Http\Pipeline;

use Laminas\Stratigility\MiddlewarePipe;
use Psr\Http\Server\MiddlewareInterface;
use Framework\Http\Middleware\Exception\UnknownMiddlewareTypeException;

class MiddlewareResolver
{
    /**
     * Resolve given parameter $handler
     * 
     * @template T of MiddlewareInterface
     * @template TValue string|T
     * 
     * @param string|array<positive-int, TValue>|T $handler
     * @throws UnknownMiddlewareTypeException
     * 
     * @return T
     */
    public function resolve($handler): MiddlewareInterface
    {
        if (\is_array($handler)) {
            return $this->createPipe($handler);
        }

        /** @var class-string<MiddlewareInterface> $handler */
        if (\is_string($handler)) {

            if (! class_exists($handler)) {
                throw new UnknownMiddlewareTypeException($handler);
            }

            /** @var MiddlewareInterface */
            $middleware = new $handler();

            if ($middleware instanceof MiddlewareInterface) {
                return $middleware;
            }            
        }

        if ($handler instanceof MiddlewareInterface) {
            return $handler;
        }

        throw new UnknownMiddlewareTypeException(\gettype($handler));
    }


    private function createPipe(array $middlewares): MiddlewarePipe
    {
        $pipeline = new MiddlewarePipe();

        /** @var class-string<MiddlewareInterface>|MiddlewareInterface $middleware */
        foreach ($middlewares as $middleware) {
            $pipeline->pipe($this->resolve($middleware));
        }

        return $pipeline;
    }
}
