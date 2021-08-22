<?php

namespace Test\Framework\Http;

use Laminas\Diactoros\Response\HtmlResponse;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function testEmpty(): void
    {
        $content = 'HTTP content';
        $response = new HtmlResponse($content);
 
        self::assertEquals($content, $response->getBody()->getContents());
        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('OK', $response->getReasonPhrase());
    }

    public function testStatus404(): void
    {
        $content = 'HTTP content';
        $response = new HtmlResponse($content, $statusCode = 404);
 
        self::assertEquals($content, $response->getBody()->getContents());
        self::assertEquals(mb_strlen($content), $response->getBody()->getSize());

        self::assertEquals($statusCode, $response->getStatusCode());
        self::assertEquals('Not Found', $response->getReasonPhrase());
    }

    public function testHeaders(): void
    {       
        $response = (new HtmlResponse($content = 'HTTP content'))
            ->withHeader($headerName1 = 'X-Name-1', $headerValue1 = 'Value_1')
            ->withHeader($headerName2 = 'X-Name-2', $headerValue2 = 'Value_2');
         

        self::assertEquals([
            $headerName1 => [$headerValue1],
            $headerName2 => [$headerValue2],
            'content-type' => ['text/html; charset=utf-8'],
        ], $response->getHeaders());
    }
}
