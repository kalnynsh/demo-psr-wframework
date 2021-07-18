<?php

namespace App\Http\Action\Home;

use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class CabinetAction
{
    public function __invoke(ServerRequestInterface $request): Response
    {
        return new HtmlResponse('Cabinet.');
    }
}
