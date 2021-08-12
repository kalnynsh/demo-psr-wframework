<?php

namespace App\Http\Action\Home;

use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class IndexAction
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var string $name */
        $name = $request->getQueryParams()['name'] ?? 'Guest';
        $content = '<p>Welcome ' . $name . '!</p>';

        return new HtmlResponse($content);
    }
}
