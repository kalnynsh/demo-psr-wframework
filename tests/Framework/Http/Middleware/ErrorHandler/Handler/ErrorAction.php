<?php

namespace Test\Framework\Http\Middleware\ErrorHandler\Handler;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ErrorAction implements RequestHandlerInterface
{
    /**
     * handle function
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \RuntimeException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            throw new \RuntimeException('Runtime error', 500);

            return new HtmlResponse('All good');
        } catch (\RuntimeException $e) {
            return new HtmlResponse($e->getMessage(), $e->getCode());
        }
    }
}
