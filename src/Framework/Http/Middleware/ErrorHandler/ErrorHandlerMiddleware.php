<?php

namespace Framework\Http\Middleware\ErrorHandler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGeneratorInterface;

class ErrorHandlerMiddleware implements MiddlewareInterface
{
    private ErrorResponseGeneratorInterface $responseGenerator;

    public function __construct(ErrorResponseGeneratorInterface $responseGenerator)
    {
        $this->responseGenerator = $responseGenerator;
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        try {
            return $handler->handle($request);
        } catch (\Throwable $exception) {
            return $this->responseGenerator->generate($exception, $request);
        }
    }
}