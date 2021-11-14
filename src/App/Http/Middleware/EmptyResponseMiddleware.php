<?php

namespace App\Http\Middleware;

use Framework\Template\Php\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Fig\Http\Message\StatusCodeInterface as StatusCode;
use Laminas\Diactoros\Stream;
use Psr\Http\Message\StreamInterface;

class EmptyResponseMiddleware implements MiddlewareInterface
{
    private TemplateRenderer $renderer;

    public function __construct(TemplateRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $response = $handler->handle($request);
        $responseSize = $response->getBody()->getSize();
        $statusCode = $response->getStatusCode();


        if ($responseSize === 0 && $statusCode === StatusCode::STATUS_FORBIDDEN) {
            return $response
                ->withBody(
                    self::createBody(
                        $this->renderer->render(
                            '/error/403',
                            ['request' => $request]
                        )
                    )
                );
        }

        if ($responseSize === 0 && $statusCode === StatusCode::STATUS_NOT_FOUND) {
            return $response
                ->withBody(
                    self::createBody(
                        $this->renderer->render(
                            '/error/404',
                            ['request' => $request]
                        )
                    )
                );
        }

        return $response;
    }

    private static function createBody(string $content): StreamInterface
    {
        $body = new Stream('php://temp', 'wb+');
        $body->write($content);

        return $body;
    }
}
