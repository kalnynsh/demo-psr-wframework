<?php

namespace App\Http\Action\Blog;

use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;

class ShowAction
{
    public function __invoke(ServerRequestInterface $request, callable $next): Response
    {
        $id = $request->getAttribute('id');
        $request = $request->withAttribute('total', 2);

        if ($id > $request->getAttribute('total')) {
            return $next($request);
        }

        return new JsonResponse(
                ['id' => $id, 'title' => 'The Post #' . $id],
            );
    }
}
