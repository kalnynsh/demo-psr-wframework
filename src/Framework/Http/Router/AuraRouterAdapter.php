<?php

namespace Framework\Http\Router;

use Aura\Router\Route;
use Aura\Router\RouterContainer;
use Framework\Http\Router\Result;
use Aura\Router\Exception\RouteNotFound;
use Framework\Http\Router\RouterInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Http\Router\Exception\RouteNotFoundException;
use Framework\Http\Router\Exception\RequestNotMatchedException;

class AuraRouterAdapter implements RouterInterface
{
    private RouterContainer $aura;

    public function __construct(RouterContainer $aura)
    {
        $this->aura = $aura;
    }

    /**
     * match method
     *
     * @param ServerRequestInterface $request
     * @throws RequestNotMatchedException
     * @return Result
     */
    public function match(ServerRequestInterface $request): Result
    {
        $matcher = $this->aura->getMatcher();

        /** @var Route $route */
        if ($route = $matcher->match($request)) {

            return $this->getResult(
                $route->name, 
                $route->handler, 
                $route->attributes
            );
        }

        throw new RequestNotMatchedException($request);
    }

    /**
     * Generate route by given name and params
     *
     * @param string $routeName
     * @param array  $params
     * 
     * @throws RouteNotFoundException
     * @return string|false
     */
    public function generate(string $routeName, array $params = []): string|false
    {
        $generator = $this->aura->getGenerator();

        try {
            return $generator->generate($routeName, $params);
        } catch (RouteNotFound $exc) {
            throw new RouteNotFoundException($routeName, $params, $exc);
        }
    }

    public function addRoute(RouteDto $routeDto): void
    {
        $route = $this->getRoute();

        $route->name($routeDto->getName());
        $route->path($routeDto->getPath());
        $route->handler($routeDto->getHandler());

        foreach ($routeDto->getOptions() as $name => $value) {

            if ($name === 'tokens') {

                $route->tokens($value);

            } elseif ($name === 'defaults') {

                $route->defaults($value);

            } elseif ($name === 'wildcard') {

                $route->wildcard($value);
                break;

            } else {
                throw new \InvalidArgumentException('Undefined option "' . $name . '"');
            }           
        }

        if ($methods = $routeDto->getMethods()) {
            $route->allows($methods);
        }

        $this->aura->getMap()->addRoute($route);
    }

    private function getRoute(): Route
    {
        return new Route();
    }

    private function getResult(
        string $name, 
        mixed $handler, 
        array $attributes
    ): Result
    {
        return new Result($name, $handler, $attributes);
    }
}
