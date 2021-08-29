<?php

namespace App\Http\Action\Home;

use Psr\Http\Message\ResponseInterface;
use Framework\Template\TemplateRenderer;
use Framework\Template\ViewPathResolver;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AboutAction implements RequestHandlerInterface
{
    private TemplateRenderer $renderer;
    private ViewPathResolver $viewPathResolver;

    public function __construct(TemplateRenderer $renderer)
    {
        $this->renderer = $renderer;

        $this->viewPathResolver = new ViewPathResolver(
            __DIR__,
            get_class($this)
        );
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $aboutContent = 'Long, long time ago...';

        /** @var string $content */
        $content = $this->renderer->render(
            $this->viewPathResolver->getViewPathPostfix(),
            [
                'aboutContent' => $aboutContent,
            ]
        );

        return new HtmlResponse($content);
    }
}
