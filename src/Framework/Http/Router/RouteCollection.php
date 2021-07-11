<?php

namespace Framework\Http\Router;

use Framework\Http\Router\Route\Route;
use Framework\Http\Router\Route\RegexpRoute;

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
        $this->addRoute(new RegexpRoute(
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
        $this->addRoute(new RegexpRoute(
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
        $this->addRoute(new RegexpRoute(
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
        $this->addRoute(new RegexpRoute(
            $name, 
            $pattern, 
            $handler,
            $methods = ['POST'],
            $tokens
        ));
    }

    /**
     * @return ReqexpRoute[]
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}
