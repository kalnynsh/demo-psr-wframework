<?php

namespace Framework\Http\Middleware;

use Framework\Http\Router\Result;
use Framework\Http\Router\Router;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Psr\Http\Message\ResponseInterface;

class RouteMiddleware
{
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response, 
        callable $next
    ) {
        try {
            $result = $this->router->match($request);

            foreach ($result->getAttributes() as $attributeName => $attributeValue) {
                $request->withAttribute($attributeName, $attributeValue);
            }

            return $next(
                $request->withAttribute(Result::class, $result), 
                $response
            );
            
        } catch (RequestNotMatchedException $e) {
            return $next($request, $response);
        }
    }
}
