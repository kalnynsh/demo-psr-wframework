<?php

namespace Test\Framework\Http\Pipeline;

use Laminas\Diactoros\Response;
use PHPUnit\Framework\TestCase;
use Laminas\Diactoros\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Http\Pipeline\MiddlewareResolver;
use Laminas\Diactoros\Response\EmptyResponse;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

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
        $resolver = new MiddlewareResolver();
        $middleware = $resolver->resolve($givenMiddleware);

        $request = (new ServerRequest())
            ->withAttribute('attribute', $value = 'value');

        $handler = new class implements RequestHandlerInterface 
        {
            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                return new Response();
            }
        };

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
        $resolver = new MiddlewareResolver();
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
            'Psr_15_Class' => [
                Psr15Middleware::class
            ],
            'Psr_15_Object' => [
                new Psr15Middleware()
            ],
        ];
    }
}

class Psr15Middleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->getAttribute('next')) {
            return $handler->handle($request);
        }

        /** @vat string valueOfHeaderAttribute */
        $valueOfHeaderAttribute = $request->getAttribute('attribute', $default = 'empty_attribute');

        return (new HtmlResponse('I am the HTML response'))
            ->withHeader('X-Header', $valueOfHeaderAttribute);
    }    
}

class DummyMiddleware
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        
        return $response->withHeader('X-Dummy', 'dummy');
    }
}

class NotFoundMiddleware
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return new EmptyResponse(404);
    }
}

class SimpleHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new Response();
    }
}

class NextHandler implements RequestHandlerInterface 
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return (new Response())->withHeader('X-Next', $value = 'move');
    }
}
