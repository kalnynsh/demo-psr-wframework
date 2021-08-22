<?php

namespace Test\App\Http\Action\Blog;

use PHPUnit\Framework\TestCase;
use Framework\Http\Router\Result;
use App\Http\Action\Blog\ShowAction;
use Laminas\Diactoros\ServerRequest;

class ShowActionTest extends TestCase
{
    public $backupStaticAttributes = false;
    public $runTestInSeparateProcess = true;

    public function testSuccess():void
    {
        $action = new ShowAction();
        $id = 2;

        $result = new Result(
            'blog_show', 
            ShowAction::class,
            ['id' => $id]
        );

        $request = (new ServerRequest())
            ->withAttribute(Result::class, $result);

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
        $id = 100;

        $result = new Result(
            'blog_show', 
            ShowAction::class,
            ['id' => $id]
        );

        $request = (new ServerRequest())
            ->withAttribute(Result::class, $result);

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
