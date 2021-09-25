<?php

namespace Framework\Http\Middleware\ErrorHandler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface ErrorResponseGeneratorInterface
{
    public function generate(
        \Throwable $exception,
        ServerRequestInterface $request
    ): ResponseInterface;
}
