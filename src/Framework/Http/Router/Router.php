<?php

namespace Framework\Http\Router;

use Framework\Http\Router\Result;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Http\Router\Exception\RouteNotFoundException;
use Framework\Http\Router\Exception\RequestNotMatchedException;

interface Router
{
    /**
     * @param ServerRequestInterface $request
     * @throws RequestNotMatchedException
     * @return Result
     */
    public function match(ServerRequestInterface $request): Result;

    /**
     * @param string $routeName
     * @param array $params
     * @throws RouteNotFoundException
     * @return string|false
     */
    public function generate(string $routeName, array $params = []): string|false;
}
