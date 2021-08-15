<?php

namespace App\Http\Action\Blog;

use Framework\Http\Router\Result;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Fig\Http\Message\StatusCodeInterface as StatusCode;

class ShowAction implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var Result $result */
        $result = $request->getAttribute(Result::class);

        /** @var array<non-empty-string, non-empty-string> $attributesOfResult */
        $attributesOfResult = $result->getAttributes();

        /** @var int $id */        
        $id = intval($attributesOfResult['id']);   

        $request = $request->withAttribute('total', 2);

        /** @var int $total */
        $total = intval($request->getAttribute('total'));

        if ($id > $total) {
            $response = new JsonResponse(
                ['id' => 0, 'title' => 'The Post #' . $id . ' not exists.'],
            );

            return $response->withStatus(
                StatusCode::STATUS_NOT_FOUND, 
                'Not Found'
            );
        }

        return new JsonResponse(
            ['id' => $id, 'title' => 'The Post #' . $id],
        );
    }
}
