<?php

namespace App\Http\Action\Blog;

use App\DAO\Post\PostArrayDAO;
use App\Service\Pagination\Pagination;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Framework\Template\TemplateRendererInterface;

class IndexAction implements RequestHandlerInterface
{
    private const PER_PAGE = 3;

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
        $pager = new Pagination(
            $this->repository->countAll(),
            $request->getAttribute('page') ?: 1,
            self::PER_PAGE
        );

        $posts = $this->repository->all(
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
