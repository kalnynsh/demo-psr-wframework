<?php

namespace Test\Framework\Http;

use Framework\Http\Application;
use PHPUnit\Framework\TestCase;
use Framework\Http\Router\RouterInterface;
use Test\Framework\Container\ContainerMock;
use Framework\Http\Pipeline\MiddlewareResolver;
use Laminas\Diactoros\ServerRequest;
use Test\Framework\Http\Middleware\MiddlewareOne;

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

        $request = new ServerRequest();
        $response = $app->handle($request);

        $this->assertJsonStringEqualsJsonString(
            \json_encode([
                'middleware-one' => 1,
            ]),
            $response->getBody()->getContents()
        );
    }
}
