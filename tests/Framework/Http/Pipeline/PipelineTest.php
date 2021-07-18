<?php

namespace Test\Framework\Http\Pipeline;

use PHPUnit\Framework\TestCase;
use Laminas\Diactoros\ServerRequest;
use Framework\Http\Pipeline\Pipeline;

class PipelineTest extends TestCase
{
    public function testPipe(): void
    {
        $pipeline = new Pipeline();

        $pipeline->pipe(new Middleware1);
        $pipeline->pipe(new Middleware2);

        $response = $pipeline(new ServerRequest(), new Last());

        $this->assertJsonStringEqualsJsonString(
            json_encode(['middleware-1' => 1, 'middleware-2' => 2]),
            $response->getBody()->getContents()
        );
    }
}
