<?php

namespace App\Http\Middleware\ErrorHandler;

use Laminas\Stratigility\Utils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Template\TemplateRendererInterface;

class PrettyErrorResponseGenerator implements ErrorResponseGeneratorInterface
{
    private TemplateRendererInterface $template;
    private ResponseInterface $response;
    private array $views;

    public function __construct(
        TemplateRendererInterface $template,
        ResponseInterface $response,
        array $views
    ) {
        $this->template = $template;
        $this->response = $response;
        $this->views = $views;
    }

    public function generate(\Throwable $exception, ServerRequestInterface $request): ResponseInterface
    {
        $code = Utils::getStatusCode($exception, $this->response);

        $response = $this->response->withStatus($code);

        $response
            ->getBody()
            ->write($this->template->render($this->getView((string) $code), [
                'request' => $request,
                'exception' => $exception,
            ]));

        return $response;
    }

    private function getView(string $code): string
    {
        if (array_key_exists($code, $this->views)) {
            (string) $view = $this->views[$code];
        }

        if (! array_key_exists($code, $this->views)) {
            (string) $view = $this->views['error'];
        }

        return $view;
    }
}
