<?php

namespace Framework\Http\Middleware\ErrorHandler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGeneratorInterface;

class ErrorHandlerMiddleware implements MiddlewareInterface
{
    /** @var callable[] $listeners */
    private array $listeners = [];
    private ErrorResponseGeneratorInterface $responseGenerator;

    public function __construct(
        ErrorResponseGeneratorInterface $responseGenerator,
    ) {
        $this->responseGenerator = $responseGenerator;
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        try {
            return $handler->handle($request);
        } catch (\Throwable $exception) {
            foreach ($this->listeners as $listener) {
                $listener($exception, $request);
            }

            return $this->responseGenerator->generate($exception, $request);
        }
    }

    public function addListener(callable $listener): void
    {
        $this->listeners[] = $listener;
    }
}
