<?php

namespace App\Http\Middleware;

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ErrorHandlerMiddleware
{
    private $isDebugMode;

    public function __construct($isDebugMode = false)
    {
        $this->isDebugMode = $isDebugMode;
    }

    public function __invoke(ServerRequestInterface $request, callable $next): ResponseInterface
    {
        try {

            return $next($request);
            
        } catch (\Throwable $exception) {

            if ($this->isDebugMode) {

                return new JsonResponse([
                    'error' => 'Server error',
                    'code' => $exception->getCode(),
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTrace(),
                ], 500);
            }

            return new HtmlResponse('Internal server error', 500);
        }
    }
}
