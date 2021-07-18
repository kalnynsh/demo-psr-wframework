<?php

namespace App\Http\Action\Home;

use Laminas\Diactoros\Response;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response\HtmlResponse;

class CabinetAction
{
    public function __invoke(ServerRequestInterface $request): Response
    {
        $username = $request->getAttribute('username');

        return new HtmlResponse('I am logged in as ' . $username);
    }
}
