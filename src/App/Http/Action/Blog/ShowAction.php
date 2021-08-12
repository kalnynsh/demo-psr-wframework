<?php

namespace App\Http\Action\Blog;

use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;

class ShowAction
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var int $id */
        $id = $request->getAttribute('id');
        $id = intval($id);

        $request = $request->withAttribute('total', 2);

        if ($id > $request->getAttribute('total')) {
            return new JsonResponse(
                ['id' => 0, 'title' => 'The Post #' . $id . ' not exists.'],
            );;
        }

        return new JsonResponse(
            ['id' => $id, 'title' => 'The Post #' . $id],
        );
    }
}
