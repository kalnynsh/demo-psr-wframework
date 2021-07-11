<?php

namespace Test\Framework\Http;

use Framework\Http\Router\Exception\RequestNotMatchedException;
use Laminas\Diactoros\Uri;
use PHPUnit\Framework\TestCase;
use Framework\Http\Router\Router;
use Laminas\Diactoros\ServerRequest;
use Framework\Http\Router\RouteCollection;

class RouterTest extends TestCase
{
    public function testCorrectMethod(): void
    {
        $routes = new RouteCollection();

        $routes->get($nameGet = 'blog', $pattern = '/blog', $handlerGet = 'handler_get');
        $routes->post($namePost = 'blog_edit', $pattern = '/blog', $handlerPost = 'handler_post');

        $router = new Router($routes);

        $resultGet = $router->match($this->buildRequest('GET', '/blog'));

        self::assertEquals($nameGet, $resultGet->getName());
        self::assertEquals($handlerGet, $resultGet->getHandler());

        $resultPost = $router->match($this->buildRequest('POST', '/blog'));

        self::assertEquals($namePost, $resultPost->getName());
        self::assertEquals($handlerPost, $resultPost->getHandler());
    }

    public function testMissingMethod()
    {
        $routes = new RouteCollection();
        $routes->post('blog', '/blog', 'handler_post');
        $router = new Router($routes);

        $this->expectException(RequestNotMatchedException::class);
        $router->match($this->buildRequest('DELETE', '/blog'));
    }

    public function testCorrectAttributes(): void
    {
        $routes = new RouteCollection();

        $routes->get(
            $routeName = 'blog_show', 
            '/blog/{id}', 
            'blog_show_handler', 
            ['id' => '\d+']
        );

        $router = new Router($routes);

        $result = $router->match($this->buildRequest('GET', '/blog/5'));

        self::assertEquals($routeName, $result->getName());
        self::assertEquals(['id' => 5], $result->getAttributes());
    }

    public function testIncorrectAttributes(): void
    {
        $routes = new RouteCollection();

        $routes->get(
            $routeName = 'blog_show', 
            '/blog/{id}', 
            'blog_show_handler', 
            ['id' => '\d+']
        );

        $router = new Router($routes);

        $this->expectException(RequestNotMatchedException::class);
        $result = $router->match($this->buildRequest('GET', '/blog/slug'));
    }

    public function testGenerator(): void
    {
        $routes = new RouteCollection();

        $routes->get(
            $blogRouteName = 'blog', 
            $blogUriPattern = '/blog', 
            'blogs_list_handler'
        );

        $routes->get(
            $blogShowRouteName = 'blog_show', 
            '/blog/{id}', 
            'blog_show_handler', 
            ['id' => '\d+']
        );

        $router = new Router($routes);

        self::assertEquals($blogUriPattern, $router->generate($blogRouteName));

        self::assertEquals(
            '/blog/5', 
            $router->generate(
                $blogShowRouteName, 
                ['id' => 5]
            )
        );
    }

    public function testGeneratorWithMissingAttributes(): void
    {
        $routes = new RouteCollection();

        $routes->get(
            $blogShowRouteName = 'blog_show', 
            '/blog/{id}', 
            'blog_show_handler', 
            ['id' => '\d+']
        );

        $router = new Router($routes);

        $this->expectException(\InvalidArgumentException::class);
        $router->generate($blogShowRouteName, ['slug' => 'post_one']);
    }

    private function buildRequest($method, $uri): ServerRequest
    {
        return (new ServerRequest())
            ->withMethod($method)
            ->withUri(new Uri($uri));
    }
}
