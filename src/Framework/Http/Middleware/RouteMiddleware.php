<?php

namespace Framework\Http\Middleware;

use Framework\Http\MiddlewareResolver;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\Router;
use Psr\Http\Message\ServerRequestInterface;

class RouteMiddleware
{
    private $router;
    private $resolver;

    public function __construct(Router $router, MiddlewareResolver $resolver)
    {
        $this->router = $router;
        $this->resolver = $resolver;
    }

    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        try {
            $result = $this->router->match($request);

            foreach ($result->getAttributes() as $attributeName => $attributeValue) {
                $request->withAttribute($attributeName, $attributeValue);
            }

            $middleware = $this->resolver->resolve($result->getHandler());

            return $middleware($request, $next);
        } catch (RequestNotMatchedException $e) {
            return $next($request);
        }
    }
}
