<?php

namespace App\Http\Action\Home;

use Psr\Http\Message\ResponseInterface;
use Framework\Template\TemplateRenderer;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class IndexAction implements RequestHandlerInterface
{
    private TemplateRenderer $renderer;

    public function __construct(TemplateRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var string $name */
        $name = $request->getQueryParams()['name'] ?? 'Guest';

        $content = $this->renderer->render(
            $this->getViewPathPostfix(),
            [
                'name' => $name,
            ]
        );

        return new HtmlResponse($content);
    }

    private function getViewPathPostfix(): string
    {
        $fullClassName = get_class($this);
        $className = $this->getLastWord($fullClassName,'\\');
        $viewName = mb_strtolower(rtrim($className, 'Action'));
        $dirName = $this->getLastWord(__DIR__,DIRECTORY_SEPARATOR);
        $dirName = mb_strtolower($dirName);

        return $dirName . DIRECTORY_SEPARATOR . $viewName;
    }

    private function getLastWord(
        string $wordWithSeparators,
        string $separator = '\\'
    ): string
    {
        if ($namePosition = strrpos($wordWithSeparators, $separator)) {
            return substr($wordWithSeparators, $namePosition + 1);
        }

        return $wordWithSeparators;
    }
}
