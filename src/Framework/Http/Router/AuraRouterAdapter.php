<?php

namespace Framework\Http\Router;

use Aura\Router\RouterContainer;
use Framework\Http\Router\Result;
use Aura\Router\Exception\RouteNotFound;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\Exception\RouteNotFoundException;

class AuraRouterAdapter implements Router
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

        if ($route = $matcher->match($request)) {
            return new Result($route->name, $route->handler, $route->attributes);
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
}
