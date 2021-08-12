<?php

namespace Framework\Http\Middleware;

use Framework\Http\Router\Result;
use Framework\Http\Router\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Framework\Http\Router\Exception\RequestNotMatchedException;

class RouteMiddleware implements MiddlewareInterface
{
    private Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        try {
            /**
             * @var Result $result
             */
            $result = $this->router->match($request);

            /**
             * @var string $attributeName
             * @var string $attributeValue
             */
            foreach ($result->getAttributes() as $attributeName => $attributeValue) {
                $request->withAttribute($attributeName, $attributeValue);
            }

            return $handler->handle(
                $request->withAttribute(Result::class, $result)
            );
            
        } catch (RequestNotMatchedException $exception) {
            return $handler->handle($request);
        }
    }
}
