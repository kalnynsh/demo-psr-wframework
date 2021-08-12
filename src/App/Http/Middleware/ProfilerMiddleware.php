<?php

namespace App\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ProfilerMiddleware implements MiddlewareInterface
{
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface
    {
        $start = microtime(true);
        $stop = microtime(true);
        
        /** @var string $interval */
        $interval = strval($stop - $start);

        $response = $handler->handle($request);
        $response->withHeader('X-Profilers-Duration', $interval);

        return $response;
    }
}
