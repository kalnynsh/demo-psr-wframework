<?php

namespace Test\Framework\Http\Middleware\ErrorHandler;

use Framework\Http\Middleware\ErrorHandler\ErrorResponseGeneratorInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DummyGenerator implements ErrorResponseGeneratorInterface
{
    public function generate(\Throwable $exception, ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse($exception->getMessage(), 500);
    }
}
