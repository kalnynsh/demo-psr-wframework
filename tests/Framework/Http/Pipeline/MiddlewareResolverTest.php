<?php

namespace Test\Framework\Http\Pipeline;

use Laminas\Diactoros\Response;
use PHPUnit\Framework\TestCase;
use Laminas\Diactoros\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Test\Framework\Container\ContainerMock;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Framework\Http\Pipeline\MiddlewareResolver;

class MiddlewareResolverTest extends TestCase
{
    public $backupStaticAttributes = false;
    public $runTestInSeparateProcess = true;

    /**
     * @dataProvider getValidHandlers
     * 
     * @param class-string<MiddlewareInterface>|MiddlewareInterface $givenMiddleware
     */
    public function testDirect($givenMiddleware): void
    {
        $resolver = new MiddlewareResolver(
            $this->getContainerMock()
        );

        $middleware = $resolver->resolve($givenMiddleware);

        $request = (new ServerRequest())
            ->withAttribute('attribute', $value = 'value');

        $handler = new SimpleHandler();

        /** @var ResponseInterface $response */
        $response = $middleware->process($request, $handler);

        self::assertEquals([$value], $response->getHeader('X-Header'));
    }

    /**
     * @dataProvider getValidHandlers
     * 
     * @param class-string<MiddlewareInterface>|MiddlewareInterface $givenMiddleware
     */
    public function testNext($givenMiddleware): void
    {
        $serviceLocatorMock = $this->getContainerMock();
        $resolver = new MiddlewareResolver($serviceLocatorMock);
        $middleware = $resolver->resolve($givenMiddleware);

        $request = (new ServerRequest())
            ->withAttribute('next', true);

        $handler = new NextHandler();

        /** @var ResponseInterface $response */
        $response = $middleware->process($request, $handler);

        self::assertEquals(['move'], $response->getHeader('X-Next'));
    }

    public function getValidHandlers(): array
    {
        return [
            'Psr_15_class_string' => [
                Psr15Middleware::class
            ],
            'Psr_15_Object' => [
                new Psr15Middleware()
            ],
        ];
    }

    private function getContainerMock(): ContainerMock
    {
        return new ContainerMock();
    }
}
