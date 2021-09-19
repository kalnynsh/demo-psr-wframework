<?php

namespace Test\Framework\Http;

use Framework\Http\Application;
use PHPUnit\Framework\TestCase;
use Laminas\Diactoros\ServerRequest;
use Framework\Http\Router\RouterInterface;
use Test\Framework\Container\ContainerMock;
use Framework\Http\Pipeline\MiddlewareResolver;
use Test\Framework\Http\Handler\DefaultHandler;
use Test\Framework\Http\Middleware\MiddlewareOne;
use Test\Framework\Http\Middleware\MiddlewareTwo;

class ApplicationTest extends TestCase
{
    /** @var MiddlewareResolver */
    private $resolver;

    /** @var RouterInterface */
    private $router;

    public function setUp(): void
    {
        parent::setUp();

        $this->resolver = new MiddlewareResolver(new ContainerMock());
        $this->router = $this->createMock(RouterInterface::class);
    }

    public function testPipe(): void
    {
        $app = new Application($this->resolver, $this->router);

        $app->pipe(new MiddlewareOne());
        $app->pipe(new MiddlewareTwo());

        $request = new ServerRequest();
        $defaultHandler = new DefaultHandler();
        $response = $app->process($request, $defaultHandler);

        $this->assertJsonStringEqualsJsonString(
            \json_encode([
                'middleware-one' => 1,
                'middleware-two' => 2,
            ]),
            $response->getBody()->getContents()
        );
    }
}
