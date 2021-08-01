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
    /**
     * @dataProvider getValidHandlers
     * @param mixed $handler
     */
    public function testDirect($handler): void
    {
        $resolver = new MiddlewareResolver();
        $middleware = $resolver->resolve($handler);

        /** @var ResponseInterface $response */
        $response = $middleware(
            (new ServerRequest())
                ->withAttribute('attribute', $value = 'value'),
            new Response(),
            new NotFoundMiddleware()
        );

        self::assertEquals([$value], $response->getHeader('X-Header'));
    }

    /**
     * @dataProvider getValidHandlers
     * @param mixed $handler
     */
    public function testNext($handler): void
    {
        $resolver = new MiddlewareResolver();
        $middleware = $resolver->resolve($handler);

        /** @var ResponseInterface $response */
        $response = $middleware(
            (new ServerRequest())
                ->withAttribute('next', true),
            new Response(),
            new NotFoundMiddleware()
        );

        self::assertEquals(404, $response->getStatusCode());
    }


    public function testArray(): void
    {
        $resolver = new MiddlewareResolver();

        $middleware = $resolver->resolve([
            new DummyMiddleware(),
            new CallableMiddleware()
        ]);

        /** @var ResponseInterface $response */
        $response = $middleware(
            (new ServerRequest())
                ->withAttribute('attribute', $value = 'value'),
            new Response(),
            new NotFoundMiddleware()
        );

        self::assertEquals(['dummy'], $response->getHeader('X-Dummy'));
        self::assertEquals([$value], $response->getHeader('X-Header'));
    }

    public function getValidHandlers(): array
    {
        return [
            'Callable Callback' => [
                function (ServerRequestInterface $request, callable $next) {
                    if ($request->getAttribute('next')) {
                        return $next($request);
                    }

                    return (new HtmlResponse(''))
                        ->withHeader('X-Header', $request->getAttribute('attribute'));
                }
            ],

            'Callable Class' => [CallableMiddleware::class],
            'Callable Object' => [new CallableMiddleware()],

            'DoublePass Callback' => [
                function (ServerRequestInterface $request, ResponseInterface $response, callable $next) {
                    if ($request->getAttribute('next')) {
                        return $next($request);
                    }

                    return (new HtmlResponse(''))
                        ->withHeader('X-Header', $request->getAttribute('attribute'));
                }
            ],
            'DoublePass Class' => [DoublePassMiddleware::class],
            'DoublePass Object' => [new DoublePassMiddleware()],

            'Psr_15 Class' => [
                Psr15Middleware::class
            ],
            'Psr_15 Object' => [
                new Psr15Middleware()
            ],
        ];
    }

    
    
}

class CallableMiddleware
{
    public function __invoke(ServerRequestInterface $request, callable $next): ResponseInterface
    {
        if ($request->getAttribute('next')) {
            return $next($request);
        }

        return (new HtmlResponse(''))
            ->withHeader('X-Header', $request->getAttribute('attribute'));
    }
    
}

class DoublePassMiddleware
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next): ResponseInterface
    {
        if ($request->getAttribute('next')) {
            return $next($request);
        }

        return $response
            ->withHeader('X-Header', $request->getAttribute('attribute'));
    }    
}

class Psr15Middleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->getAttribute('next')) {
            return $handler->handle($request);
        }

        return (new HtmlResponse(''))
            ->withHeader('X-Header', $request->getAttribute('attribute'));
    }    
}

class DummyMiddleware
{
    public function __invoke(ServerRequestInterface $request, callable $next): ResponseInterface
    {
        return $next($request)
            ->withHeader('X-Dummy', 'dummy');
    }
}


class NotFoundMiddleware
{
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        return new EmptyResponse(404);
    }
}
