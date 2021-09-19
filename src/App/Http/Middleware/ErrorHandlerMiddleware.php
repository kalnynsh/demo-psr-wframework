<?php

namespace App\Http\Middleware;

use Framework\Template\TemplateRendererInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ErrorHandlerMiddleware implements MiddlewareInterface
{
    private bool $isDebugMode;
    private TemplateRendererInterface $template;

    public function __construct(
        bool $isDebugMode,
        TemplateRendererInterface $template
    ) {
        $this->isDebugMode = $isDebugMode;
        $this->template = $template;
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        try {
            return $handler->handle($request);
        } catch (\Throwable $exception) {
            $view = $this->isDebugMode ? 'error/error-debug' : 'error/error';

            return new JsonResponse([
                'error' => 'Server error',
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'trace' => $exception->getTrace(),
            ], 500);

            return new HtmlResponse(
                $this
                    ->template
                    ->render(
                        $view,
                        [
                            'request' => $request,
                            'exception' => $exception,
                        ]
                    ),
                $exception->getCode() ?: 500
            );
        }
    }
}
