<?php

namespace App\Http\Action\Home;

use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;

class AboutAction
{
    public function __invoke(): Response
    {
        return new HtmlResponse('I am describer.');
    }
}
