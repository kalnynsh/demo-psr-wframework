<?php

namespace Framework\Http\Router;

use array_filter;

use Framework\Http\Router\Result;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Http\Router\Exception\RouteNotFoundException;
use Framework\Http\Router\Exception\RequestNotMatchedException;

class Router
{
    private $routes;

    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
    }

    public function match(ServerRequestInterface $request): Result
    {
        foreach ($this->routes->getRoutes() as $route) {
            if ($result = $route->match($request)) {
                return $result;
            }
        }

        throw new RequestNotMatchedException($request);
    }

    public function generate(string $routeName, array $params = []): string
    {
        foreach ($this->routes->getRoutes() as $route) {
            if (null !== $url = $route->generate($routeName, array_filter($params))) {
                return $url;
            }
        }

        throw new RouteNotFoundException($routeName, $params);
    }
}
