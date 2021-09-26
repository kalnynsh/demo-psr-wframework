<?php

namespace Framework\Http\Middleware\ErrorHandler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGeneratorInterface;
use Psr\Log\LoggerInterface;

class ErrorHandlerMiddleware implements MiddlewareInterface
{
    private ErrorResponseGeneratorInterface $responseGenerator;
    private LoggerInterface $logger;

    public function __construct(
        ErrorResponseGeneratorInterface $responseGenerator,
        LoggerInterface $logger
    ) {
        $this->responseGenerator = $responseGenerator;
        $this->logger = $logger;
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        try {
            return $handler->handle($request);
        } catch (\Throwable $exception) {
            $this
                ->logger
                ->error(
                    $exception->getMessage(),
                    [
                        'exception' => $exception,
                        'request' => self::extractRequest($request),
                    ]
                );


            return $this->responseGenerator->generate($exception, $request);
        }
    }

    private static function extractRequest(ServerRequestInterface $request): array
    {
        return [
            'method'  => $request->getMethod(),
            'url'     => (string) $request->getUri(),
            'server'  => $request->getServerParams(),
            'cookies' => $request->getCookieParams(),
            'body'    => $request->getParsedBody(),
        ];
    }
}
