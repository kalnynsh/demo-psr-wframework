<?php

namespace Tests\Freamework\Http;

use Framework\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{

    public function testEmpty(): void
    {
        // Use default params
        $request = new Request();

        self::assertEquals([], $request->getQueryParams());
        self::assertNull($request->getParsedBody(), '$_POST is null');
    }

    public function testQueryParams(): void
    {
         $request = new Request($getData = [
            'firstName' => 'John',
            'lastName' => 'Noland',
            'age' => 42,
        ], null);

        self::assertEquals($getData, $request->getQueryParams());
        self::assertNull($request->getParsedBody(), '$_POST is null');
    }

    public function testParsedfBody(): void
    {
        $postData = [
            'firstName' => 'John',
            'lastName' => 'Noland',
            'age' => 42,
        ];

        $request = new Request([], $postData);

        self::assertEquals($postData, $request->getParsedBody());
        self::assertEquals([], $request->getQueryParams());
    }
}

