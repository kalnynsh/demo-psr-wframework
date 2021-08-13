<?php

namespace App\Http\Action\Blog;

use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ShowAction implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var int $id */
        $id = $request->getAttribute('id');
        $id = intval($id);

        $request = $request->withAttribute('total', 2);

        /** @var int $total */
        $total = intval($request->getAttribute('total'));

        if ($id > $total) {
            $response = new JsonResponse(
                ['id' => 0, 'title' => 'The Post #' . $id . ' not exists.'],
            );

            return $response->withStatus(404, 'Not Found');
        }

        return new JsonResponse(
            ['id' => $id, 'title' => 'The Post #' . $id],
        );
    }
}
