<?php

namespace App\Http\Action\Home;

use Psr\Http\Message\ResponseInterface;
use Framework\Template\ViewPathResolver;
use App\Http\Middleware\BasicAuthMiddleware;
use Framework\Template\TemplateRendererInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CabinetAction implements RequestHandlerInterface
{
    private TemplateRendererInterface $renderer;
    private ViewPathResolver $viewPathResolver;

    public function __construct(TemplateRendererInterface $renderer)
    {
        $this->renderer = $renderer;

        $this->viewPathResolver = new ViewPathResolver(
            __DIR__,
            get_class($this)
        );
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var string $username */
        $username = $request->getAttribute(BasicAuthMiddleware::ATTRIBUTE);

        /** @var string $content */
        $content = $this->renderer->render(
            $this->viewPathResolver->getViewPathPostfix(),
            [
                'username' => $username,
            ]
        );

        return new HtmlResponse($content);
    }
}
