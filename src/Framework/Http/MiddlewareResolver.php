<?php

namespace Framework\Http;

use Framework\Http\Pipeline\Pipeline;
use Psr\Http\Message\ServerRequestInterface;

class MiddlewareResolver
{
    public function resolve($handler): callable
    {
        if (\is_array($handler)) {
            return $this->createPipe($handler);
        }

        if (\is_string($handler)) {
            
            return function (ServerRequestInterface $request, callable $next) use ($handler) {
                $object = new $handler();

                return $object($request, $next);
            };
        }

        /** $handler not a string and not array */
        return $handler;
    }

    private function createPipe(array $handlers): Pipeline 
    {
        $pipeline = new Pipeline();

        foreach ($handlers as $handler)  {
            $pipeline->pipe($this->resolve($handler));
        }


        return $pipeline;
    }
}
