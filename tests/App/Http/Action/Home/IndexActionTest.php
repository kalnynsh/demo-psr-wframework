<?php

namespace Test\App\Http\Action\Home;

use PHPUnit\Framework\TestCase;
use Laminas\Diactoros\ServerRequest;
use App\Http\Action\Home\IndexAction;
use Framework\Template\TemplateRenderer;

class IndexActionTest extends TestCase
{
    private TemplateRenderer $renderer;

    public $backupStaticAttributes = false;
    public $runTestInSeparateProcess = true;

    protected function setUp(): void
    {
        parent::setUp();

        $templatesPath = dirname(__DIR__, 5) . '/src/templates';

        $this->renderer = new TemplateRenderer($templatesPath);
    }

    public function testGuest(): void
    {
        $request = new ServerRequest();

        $action = new IndexAction($this->renderer);
        
        $response = $action->handle($request);

        self::assertEquals(200, $response->getStatusCode());
    }
}
