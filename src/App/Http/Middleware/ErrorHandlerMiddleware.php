<?php

namespace App\Http\Middleware;

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ErrorHandlerMiddleware implements MiddlewareInterface
{
    private bool $isDebugMode;

    public function __construct(bool $isDebugMode = false)
    {
        $this->isDebugMode = $isDebugMode;
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface
    {
        try {

            return $handler->handle($request);
            
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
