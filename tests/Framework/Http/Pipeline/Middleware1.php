<?php

namespace Test\Framework\Http\Pipeline;

use Psr\Http\Message\ServerRequestInterface;

class Middleware1
{
    public function __invoke(ServerRequestInterface $request, callable $next = null)
    {
        return $next($request->withAttribute('middleware-1', 1));
    }
}
