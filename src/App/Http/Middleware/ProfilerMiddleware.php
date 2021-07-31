<?php

namespace App\Http\Middleware;

use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ProfilerMiddleware
{
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response, 
        callable $next
    ): Response
    {
        $start = microtime(true);

        /** @var ResponseInterface $response */
        $response = $next($request, $response);

        $stop = microtime(true);

        return $response->withHeader('X-Profiler-Duration', $stop - $start);
    }
}
