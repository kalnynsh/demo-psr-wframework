<?php

use Framework\Http\RequestFactory;
use PHPUnit\Framework\TestCase;

class RequestFactoryTest extends TestCase
{
    public function testGet()
    {
        $_POST = [];

        $_GET = $getData = [
            'firstName' => 'John',
            'lastName' => 'Noland',
            'age' => 42,
        ];

        $request = RequestFactory::fromGlobals();

        self::assertEquals($getData, $request->getQueryParams());
        self::assertEquals([], $request->getParsedBody());
    }

    public function testPost()
    {
        $_GET = [];

        $_POST = $postData = [
            'firstName' => 'John',
            'lastName' => 'Noland',
            'age' => 42,
        ];

        $request = RequestFactory::fromGlobals();

        self::assertEquals([], $request->getQueryParams());
        self::assertEquals($postData, $request->getParsedBody());
    }

    public function testQueryParams()
    {
        $_POST = [];
        $_GET = [];
        
        $getData = [
            'firstName' => 'John',
            'lastName' => 'Noland',
            'age' => 42,
        ];

        $request = RequestFactory::fromGlobals($getData, $body = null);

        self::assertEquals($getData, $request->getQueryParams());
        self::assertEquals([], $request->getParsedBody());
    }

    public function testPostParams()
    {
        $_GET = [];

        $_POST = [];
        
        $postData = [
            'firstName' => 'John',
            'lastName' => 'Noland',
            'age' => 42,
        ];

        $request = RequestFactory::fromGlobals($query = null, $postData);

        self::assertEquals([], $request->getQueryParams());
        self::assertEquals($postData, $request->getParsedBody());
    }
}
