<?php

namespace Test\App\Http\Action\Home;

use PHPUnit\Framework\TestCase;
use App\Http\Action\Home\IndexAction;
use Laminas\Diactoros\ServerRequest;

class IndexActionTest extends TestCase
{
    public function testGuest(): void
    {
        $request = new ServerRequest();

        $action = new IndexAction();
        
        $response = $action($request);

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('Hello Guest!', $response->getBody()->getContents());
    }

    public function testJohn(): void
    {
        $request = (new ServerRequest())
            ->withQueryParams(['name' => 'John Noland']);

        $action = new IndexAction();

        $response = $action($request);

        self::assertEquals('Hello John Noland!', $response->getBody()->getContents());
    }
}
