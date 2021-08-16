<?php

namespace Framework\Http\Pipeline;

use Framework\Container\Container;
use Psr\Http\Server\MiddlewareInterface;
use Framework\Http\Middleware\Exception\UnknownMiddlewareTypeException;

class MiddlewareResolver
{
    private Container $serviceLocator;

    public function __construct(Container $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

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
        /** @var class-string<MiddlewareInterface>|MiddlewareInterface $handler */
        if (
            \is_string($handler) 
            && $this->serviceLocator->has($handler)
        ) {
            /** @var MiddlewareInterface */
            $middleware = $this->serviceLocator->get($handler);

            if ($middleware instanceof MiddlewareInterface) {
                return $middleware;
            }
            
            throw new UnknownMiddlewareTypeException(\gettype($handler));
        }

        if ($handler instanceof MiddlewareInterface) {
            return $handler;
        }

        throw new UnknownMiddlewareTypeException(\gettype($handler));
    }
}
