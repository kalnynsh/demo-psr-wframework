<?php

namespace App\Http\Action\Home;

use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class IndexAction
{
    public function __invoke(ServerRequestInterface $request): Response
    {
        $name = $request->getQueryParams()['name'] ?? 'Guest';
        $content = 'Hello ' . $name . '!';

        return new HtmlResponse($content);
    }
}
