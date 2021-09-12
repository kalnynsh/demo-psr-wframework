<?php

namespace App\Http\Action\Blog;

use App\Repository\Post\PostRepository;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Framework\Template\TemplateRendererInterface;

class IndexAction implements RequestHandlerInterface
{
    private PostRepository $repository;
    private TemplateRendererInterface $renderer;

    public function __construct(
        PostRepository $repository,
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
