<?php

namespace Test\Framework\Http\Pipeline;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;

class Last
{
    public function __invoke(ServerRequestInterface $request, callable $next = null)
    {
        return new JsonResponse($request->getAttributes());
    }
}
