<?php

namespace Test\App\Http\Action\Home;

use PHPUnit\Framework\TestCase;
use App\Http\Action\Home\IndexAction;
use Laminas\Diactoros\ServerRequest;

class IndexActionTest extends TestCase
{
    public $backupStaticAttributes = false;
    public $runTestInSeparateProcess = true;

    public function testGuest(): void
    {
        $request = new ServerRequest();

        $action = new IndexAction();
        
        $response = $action->handle($request);

        self::assertEquals(200, $response->getStatusCode());

        self::assertEquals(
            '<p>Welcome Guest!</p>', 
            $response->getBody()->getContents()
        );
    }

    public function testJohn(): void
    {
        $request = (new ServerRequest())
            ->withQueryParams(['name' => 'John Noland']);

        $action = new IndexAction();

        $response = $action->handle($request);

        self::assertEquals(
            '<p>Welcome John Noland!</p>', 
            $response->getBody()->getContents()
        );
    }
}
