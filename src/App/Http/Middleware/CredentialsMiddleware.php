<?php

namespace App\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CredentialsMiddleware
{
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response, 
        callable $next
    ): ResponseInterface
    {
        /** @var ResponseInterface $response */
        $response = $next($request, $response);

        return $response->withHeader('X-Devloper', 'DenisAK');
    }
}
