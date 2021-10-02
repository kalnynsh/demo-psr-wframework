<?php

namespace Infrastructure\Framework\Http\Middleware\ErrorHandler\Listener;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface;

class LogErrorListener
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(\Throwable $exception, ServerRequestInterface $request)
    {
        $this->logger->error(
            $exception->getMessage(),
            [
                'exception' => $exception,
                'request' => self::extractRequest($request),
            ]
        );
    }

    private static function extractRequest(ServerRequestInterface $request): array
    {
        return [
            'method' => $request->getMethod(),
            'url' => (string) $request->getUri(),
            'server' => $request->getServerParams(),
            'cookies' => $request->getCookieParams(),
            'body' => $request->getParsedBody(),
        ];
    }
}
