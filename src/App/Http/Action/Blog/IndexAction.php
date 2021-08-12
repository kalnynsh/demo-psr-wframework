<?php

namespace App\Http\Action\Blog;

use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class IndexAction implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse(
            [
                ['id' => 2, 'title' => 'The Second Post'],
                ['id' => 1, 'title' => 'The First Post'],
            ]
        );
    }
}
