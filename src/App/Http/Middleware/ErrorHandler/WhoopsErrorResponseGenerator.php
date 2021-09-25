<?php

namespace App\Http\Middleware\ErrorHandler;

use Laminas\Stratigility\Utils;
use Whoops\RunInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Whoops\Handler\PrettyPageHandler;

class WhoopsErrorResponseGenerator implements ErrorResponseGeneratorInterface
{
    private RunInterface $whoops;
    private ResponseInterface $response;

    public function __construct(RunInterface $whoops, ResponseInterface $response)
    {
        $this->whoops   = $whoops;
        $this->response = $response;
    }

    public function generate(\Throwable $exception, ServerRequestInterface $request): ResponseInterface
    {
        foreach ($this->whoops->getHandlers() as $handler) {
            if ($handler instanceof PrettyPageHandler) {
                $this->prepareWhoopsHandler($request, $handler);
            }
        }

        $response = $this->response->withStatus(Utils::getStatusCode($exception, $this->response));

        $response
            ->getBody()
            ->write($this->whoops->handleException($exception));

        return $response;
    }

    private function prepareWhoopsHandler(ServerRequestInterface $request, PrettyPageHandler $handler): void
    {
        $handler->addDataTable('Application request', [
            'HTTP method'            => $request->getMethod(),
            'URI'                    => (string) $request->getUri(),
            'Script'                 => $request->getServerParams()['SCRIPT_NAME'],
            'Headers'                => $request->getHeaders(),
            'Cookies'                => $request->getCookieParams(),
            'Attributes'             => $request->getAttributes(),
            'Query string arguments' => $request->getQueryParams(),
            'Parsed body'            => $request->getParsedBody(),
        ]);
    }
}
