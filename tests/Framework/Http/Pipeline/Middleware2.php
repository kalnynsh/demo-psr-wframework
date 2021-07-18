<?php

namespace Test\Framework\Http\Pipeline;

use Psr\Http\Message\ServerRequestInterface;

class Middleware2
{
    public function __invoke(ServerRequestInterface $request, callable $next = null)
    {
        return $next($request->withAttribute('middleware-2', 2));
    }
}
