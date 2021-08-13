<?php

namespace App\Http\Action\Home;

use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class IndexAction implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var string $name */
        $name = $request->getQueryParams()['name'] ?? 'Guest';
        $content = '<p>Welcome ' . $name . '!</p>';

        return new HtmlResponse($content);
    }
}
