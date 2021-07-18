<?php

namespace App\Http\Middleware;

use Laminas\Diactoros\Response;
use Psr\Http\Message\ServerRequestInterface;

class ProfilerMiddleware
{
    public function __invoke(ServerRequestInterface $request, callable $next): Response
    {
        $start = microtime(true);

        /** @var ResponseInterface $response */
        $response = $next($request);

        $stop = microtime(true);

        return $response->withHeader('X-Profiler-Duration', $stop - $start);
    }
}
