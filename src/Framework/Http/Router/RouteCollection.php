<?php

namespace Framework\Http\Router;

class RouteCollection
{
    /**
     * @property Route[] $routes
     */
    private array $routes;

    public function addRoute(Route $route): void
    {
        $this->routes[] = $route;
    }

    public function add(
        string $name, 
        string $pattern,
        $handler, 
        array $methods, 
        array $tokens = []
    ): void {
        $this->addRoute(new Route(
            $name, 
            $pattern, 
            $handler,
            $methods,
            $tokens
        ));
    }

    public function any(
        string $name, 
        string $pattern,
        $handler,
        array $tokens = []
    ): void {
        $this->addRoute(new Route(
            $name, 
            $pattern, 
            $handler,
            $methods = [],
            $tokens
        ));
    }

    public function get(
        string $name, 
        string $pattern,
        $handler,
        array $tokens = []
    ): void {
        $this->addRoute(new Route(
            $name, 
            $pattern, 
            $handler,
            $methods = ['GET'],
            $tokens
        ));
    }

    public function post(
        string $name, 
        string $pattern,
        $handler,
        array $tokens = []
    ): void {
        $this->addRoute(new Route(
            $name, 
            $pattern, 
            $handler,
            $methods = ['POST'],
            $tokens
        ));
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }
}
