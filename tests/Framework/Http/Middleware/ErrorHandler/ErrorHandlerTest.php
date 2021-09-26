<?php

namespace Test\Framework\Http\Middleware\ErrorHandler;

use PHPUnit\Framework\TestCase;
use Laminas\Diactoros\ServerRequest;
use Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use Test\Framework\Http\Middleware\ErrorHandler\Handler\ErrorAction;
use Test\Framework\Http\Middleware\ErrorHandler\Handler\CorrectAction;

class ErrorHandlerTest extends TestCase
{
    public function testNothingDone(): void
    {
        $middleware = new ErrorHandlerMiddleware(new DummyGenerator());
        $response = $middleware->process(new ServerRequest(), new CorrectAction());

        self::assertEquals('Correct', $response->getBody()->getContents());
        self::assertEquals(200, $response->getStatusCode());
    }

    public function testException(): void
    {
        $middleware = new ErrorHandlerMiddleware(new DummyGenerator());
        $response = $middleware->process(new ServerRequest(), new ErrorAction());

        self::assertEquals('Runtime error', $response->getBody()->getContents());
        self::assertEquals(500, $response->getStatusCode());
    }
}
