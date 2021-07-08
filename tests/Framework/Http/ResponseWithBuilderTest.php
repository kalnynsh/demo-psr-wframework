<?php

namespace Test\Framework\Http;

use PHPUnit\Framework\TestCase;

class ResponseWithBuilderTest extends TestCase
{
    public function testEmpty(): void
    {
        $response = (new ResponseBuilder)
            ->withBody($body = 'HTTP BODY')
            ->build();

        self::assertEquals($body, $response->getBody());
        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('OK', $response->getReasonPhrase());
    }

    public function testStatus404(): void
    {
        $response = (new ResponseBuilder)
            ->withBody($body = 'HTTP BODY')
            ->withStatus($statusCode = 404)
            ->build();

        self::assertEquals($body, $response->getBody());
        self::assertEquals($statusCode, $response->getStatusCode());
        self::assertEquals('Not Found', $response->getReasonPhrase());
    }

    public function testHeaders(): void
    {
        $response = (new ResponseBuilder)
            ->withBody($body = 'HTTP BODY')
            ->withHeader($headerName1 = 'X-Name-1', $headerValue1 = 'Value_1')
            ->withHeader($headerName2 = 'X-Name-2', $headerValue2 = 'Value_2')
            ->build();

        self::assertEquals([
            $headerName1 => $headerValue1,
            $headerName2 => $headerValue2,
        ], $response->getHeaders());
    }
}
