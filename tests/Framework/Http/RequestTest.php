<?php

namespace Tests\Freamework\Http;

use Framework\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testEmpty(): void
    {
        $_GET = [];
        $_POST = [];

        $request = new Request();

        self::assertEquals([], $request->getQueryParams());
        self::assertNull($request->getParsedBody(), '$_POST is null');
    }

    public function testQueryParams(): void
    {
        $data = [
            'firstName' => 'John',
            'lastName' => 'Noland',
            'age' => 42,
        ];

        $_GET = $data;
        $_POST = [];

        $request = new Request();

        self::assertEquals($data, $request->getQueryParams());
        self::assertNull($request->getParsedBody(), '$_POST is null');
    }

    public function testParsedfBody(): void
    {
        $data = [
            'firstName' => 'John',
            'lastName' => 'Noland',
            'age' => 42,
        ];

        $_GET = [];
        $_POST = $data;

        $request = new Request();

        self::assertEquals($data, $request->getParsedBody());
        self::assertEquals([], $request->getQueryParams());
    }
}

