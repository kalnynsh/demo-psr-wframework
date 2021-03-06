<?php

namespace App\Http\Action\Blog;

use App\DAO\Post\PostArrayDAO;
use Framework\Http\Router\Result;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Framework\Template\TemplateRendererInterface;
use Laminas\Diactoros\Response\EmptyResponse;
use Fig\Http\Message\StatusCodeInterface as StatusCode;

class ShowAction implements RequestHandlerInterface
{
    private PostArrayDAO $repository;
    private TemplateRendererInterface $renderer;

    public function __construct(
        PostArrayDAO $repository,
        TemplateRendererInterface $renderer
    ) {
        $this->repository = $repository;
        $this->renderer = $renderer;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var Result $result */
        $result = $request->getAttribute(Result::class);

        /** @var array<non-empty-string, non-empty-string> $attributesOfResult */
        $attributesOfResult = $result->getAttributes();

        /** @var int $id */
        $id = intval($attributesOfResult['id']);

        $foundPost = $this->repository->find($id);

        if ($foundPost) {
            return new HtmlResponse(
                $this->renderer->render('/blog/show', [
                    'post' => $foundPost,
                ])
            );
        }

        return new EmptyResponse(StatusCode::STATUS_NOT_FOUND);
    }
}
