<?php

namespace Test\App\Http\Action\Blog;

use App\Http\Action\Blog\ShowAction;
use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;

class ShowActionTest extends TestCase
{
    public $backupStaticAttributes = false;
    public $runTestInSeparateProcess = true;

    public function testSuccess():void
    {
        $action = new ShowAction();

        $request = (new ServerRequest())
            ->withAttribute('id', $id = 2);

        $response = $action->handle($request);

        self::assertEquals(200, $response->getStatusCode());
        self::assertJsonStringEqualsJsonString(
            json_encode([
                'id' => $id, 
                'title' => 'The Post #' . $id
            ]),
            $response->getBody()->getContents()
        );
    }

    public function testNotFound(): void
    {
        $action = new ShowAction();

        $request = (new ServerRequest())
            ->withAttribute('id', $id = 100);

        $response = $action->handle($request);

        self::assertEquals(404, $response->getStatusCode());
        self::assertEquals(
            json_encode([
                'id' => 0, 
                'title' => 'The Post #' . $id . ' not exists.'
            ]), 
            $response->getBody()->getContents()
        );
    }
}
