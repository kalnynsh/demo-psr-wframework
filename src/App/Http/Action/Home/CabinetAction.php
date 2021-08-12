<?php

namespace App\Http\Action\Home;

use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use App\Http\Middleware\BasicAuthMiddleware;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class CabinetAction
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var string $username */
        $username = $request->getAttribute(BasicAuthMiddleware::ATTRIBUTE);

        return new HtmlResponse('I am logged in as ' . $username);
    }
}
