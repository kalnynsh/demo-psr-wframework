<?php

namespace Test\Framework\Http\Middleware\ErrorHandler;

use PHPUnit\Framework\TestCase;
use Laminas\Diactoros\ServerRequest;
use Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use Psr\Log\LoggerInterface;
use Test\Framework\Http\Middleware\ErrorHandler\Handler\ErrorAction;
use Test\Framework\Http\Middleware\ErrorHandler\Handler\CorrectAction;

class ErrorHandlerTest extends TestCase
{
    /** @var \PHPUnit\Framework\MockObject\MockObject|LoggerInterface $logger  */
    private $middleware;

    protected function setUp():void
    {
        parent::setUp();

        /**
         * @var \PHPUnit\Framework\MockObject\MockObject|LoggerInterface $logger
         */
        $logger = $this->createMock(LoggerInterface::class);

        $logger
            ->expects($this->any())
            ->method('error')
            ->willReturn(null);

        $this->middleware = new ErrorHandlerMiddleware(new DummyGenerator(), $logger);
    }

    public function testNothingDone(): void
    {
        $response = $this->middleware->process(new ServerRequest(), new CorrectAction());

        self::assertEquals('Correct', $response->getBody()->getContents());
        self::assertEquals(200, $response->getStatusCode());
    }

    public function testException(): void
    {
        $response = $this->middleware->process(new ServerRequest(), new ErrorAction());

        self::assertEquals('Runtime error', $response->getBody()->getContents());
        self::assertEquals(500, $response->getStatusCode());
    }
}
