<?php

namespace Test\Framework\Http\Pipeline;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Psr15Middleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->getAttribute('next')) {
            return $handler->handle($request);
        }

        /** @vat string valueOfHeaderAttribute */
        $valueOfHeaderAttribute = $request->getAttribute('attribute', $default = 'empty_attribute');

        return (new HtmlResponse('I am the HTML response'))
            ->withHeader('X-Header', $valueOfHeaderAttribute);
    }    
}
