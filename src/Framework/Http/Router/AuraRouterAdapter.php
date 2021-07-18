<?php

namespace Framework\Http\Router;

use Aura\Router\RouterContainer;
use Framework\Http\Router\Result;
use Framework\Http\Router\Route\Route;
use Aura\Router\Exception\RouteNotFound;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\Exception\RouteNotFoundException;

class AuraRouterAdapter implements Route
{
    private $aura;

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
     * generate method
     *
     * @param string $name
     * @param array $params
     * 
     * @throws RouteNotFoundException
     * @return string
     */
    public function generate(string $name, array $params = []): string
    {
        $generator = $this->aura->getGenerator();

        try {
            return $generator->generate($name, $params);
        } catch (RouteNotFound $exc) {
            throw new RouteNotFoundException($name, $params, $exc);
        }
    }
}
