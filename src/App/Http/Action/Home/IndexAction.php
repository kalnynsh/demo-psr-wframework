<?php

namespace App\Http\Action\Home;

use Psr\Http\Message\ResponseInterface;
use Framework\Template\TemplateRenderer;
use Framework\Template\ViewPathResolver;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class IndexAction implements RequestHandlerInterface
{
    private TemplateRenderer $renderer;
    private ViewPathResolver $viewPathResolver;

    public function __construct(
        TemplateRenderer $renderer
    )
    {
        $this->renderer = $renderer;

        $this->viewPathResolver = new ViewPathResolver(
            __DIR__,
            get_class($this)
        );
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var string $name */
        $name = $request->getQueryParams()['name'] ?? 'Guest';

        /** @var string $content */
        $content = $this->renderer->render(
            $this->viewPathResolver->getViewPathPostfix(),
            [
                'name' => $name,
            ]
        );

        return new HtmlResponse($content);
    }
}
