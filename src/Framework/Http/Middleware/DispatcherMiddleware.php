<?php

namespace Framework\Http\Middleware;

use Framework\Http\Router\Result;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DispatcherMiddleware implements MiddlewareInterface
{

    public function process(
        ServerRequestInterface $request, 
        RequestHandlerInterface $handler       
    ): ResponseInterface
    {

        /** @var Result $result */
        if (! $result = $request->getAttribute(Result::class)) {
            return $handler->handle($request);
        }
        
        /** @psalm-var class-string<RequestHandlerInterface> $handlerClass */
        $handlerClass = $result->getHandler();

        /** @var RequestHandlerInterface $routerHandler */
        $routerHandler = new $handlerClass();

        return $routerHandler->handle($request);
    }
}
