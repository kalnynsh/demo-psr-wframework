<?php

namespace Framework\Http\Middleware;

use Framework\Http\Router\Result;
use Framework\Http\MiddlewareResolver;
use Psr\Http\Message\ServerRequestInterface;

class DispatcherMiddleware
{
    private $resolver;

    public function __construct(MiddlewareResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        /** @var Result $result */
        if (! $result = $request->getAttribute(Result::class)) {
            return $next($request);
        }

        $middleware = $this->resolver->resolve($result->getHandler());

        return $middleware($request, $next);
    }
}
