<?php

namespace Tests\Freamework\Http;

use Framework\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $_GET = [];
        $_POST = [];
    }

    public function testEmpty(): void
    {
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

        $_POST = $data;

        $request = new Request();

        self::assertEquals($data, $request->getParsedBody());
        self::assertEquals([], $request->getQueryParams());
    }
}

