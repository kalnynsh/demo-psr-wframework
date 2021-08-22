<?php

namespace Test\App\Http\Action\Blog;

use PHPUnit\Framework\TestCase;
use Laminas\Diactoros\ServerRequest;
use App\Http\Action\Blog\IndexAction;

class IndexActionTest extends TestCase
{
    public $backupStaticAttributes = false;
    public $runTestInSeparateProcess = true;

    public function testSuccess(): void
    {
        $action = new IndexAction();
        $request = new ServerRequest();

        $response = $action->handle($request);

        self::assertEquals(200, $response->getStatusCode());
        self::assertJsonStringEqualsJsonString(
            json_encode([
                ['id' => 2, 'title' => 'The Second Post'],
                ['id' => 1, 'title' => 'The First Post']
            ]),
            $response->getBody()->getContents()
        );
    }
}
