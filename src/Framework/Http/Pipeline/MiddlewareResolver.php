<?php

namespace Framework\Http\Pipeline;

use Psr\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Framework\Http\Middleware\Exception\UnknownMiddlewareTypeException;

class MiddlewareResolver
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
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
            && $this->container->has($handler)
        ) {
            /** @var MiddlewareInterface */
            $middleware = $this->container->get($handler);

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
