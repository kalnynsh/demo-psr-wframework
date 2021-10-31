<?php

namespace App\Http\Action\Blog;

use App\DAO\Post\PostDAO;
use App\Service\Pagination\Pagination;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Framework\Template\TemplateRendererInterface;

class IndexAction implements RequestHandlerInterface
{
    private const PER_PAGE = 3;

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
        $pager = new Pagination(
            $this->repository->getAmount(),
            $request->getAttribute('page') ?: 1,
            self::PER_PAGE
        );

        $posts = $this->repository->getAll(
            $pager->getOffset(),
            $pager->getLimit()
        );

        return new HtmlResponse(
           $this->renderer->render('blog/index', [
               'posts' => $posts,
               'pager' => $pager,
           ])
        );
    }
}
