<?php

namespace App\Http\Action\Blog;

use App\DAO\Post\PostDAO;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Framework\Template\TemplateRendererInterface;

class IndexAction implements RequestHandlerInterface
{
    private PostDAO $repository;
    private TemplateRendererInterface $renderer;

    public function __construct(
        PostDAO $repository,
        TemplateRendererInterface $renderer
    ) {
        $this->repository = $repository;
        $this->renderer = $renderer;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $posts = $this->repository->getAll();

        return new HtmlResponse(
           $this->renderer->render('blog/index', [
               'posts' => $posts,
           ])
        );
    }
}
