<?php

namespace Framework\Http\Pipeline;

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
     * @param string|T $handler
     * @throws UnknownMiddlewareTypeException
     * 
     * @return T
     */
    public function resolve($handler): MiddlewareInterface
    {

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
}
