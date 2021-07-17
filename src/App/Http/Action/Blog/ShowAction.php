<?php

namespace App\Http\Action\Blog;

use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;

class ShowAction
{
    public function __invoke(ServerRequestInterface $request): Response
    {
        $id = $request->getAttribute('id');
        $request->withAttribute('total', 2);
        $total = $request->getAttribute('total');

        if ($id > $total) {
            return new HtmlResponse('Undefined page', 404);
        }

        return new JsonResponse(
                ['id' => $id, 'title' => 'The Post #' . $id],
            );
    }
}
