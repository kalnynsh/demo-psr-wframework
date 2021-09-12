<?php

namespace Framework\Template;

use Framework\Http\Router\RouterInterface;

class TemplateRenderer implements TemplateRendererInterface
{
    private string $viewPathRoot;
    private ?string $extend;
    private array $blocks = [];
    private \SplStack $blockNames;
    private RouterInterface $router;

    public function __construct(string $viewPathRoot, RouterInterface $router)
    {
        $this->viewPathRoot = $viewPathRoot;
        $this->blockNames = new \SplStack();
        $this->router = $router;
    }

    public function setBlockCallback(string $name, \Closure $blockCallback): void
    {
        if ($this->blockExists($name)) {
            return;
        }

        $this->blocks[$name] = $blockCallback;
    }

    /**
     * Render given view
     *
     * @param string $view - view name
     * @param array $params - extracting to view
     *
     * @throws VewFileNotExists
     * @return string|null
     */
    public function render(string $view, array $params = []): ?string
    {
        /** @var string $templateFile */
        $templateFile = $this->viewPathRoot . DIRECTORY_SEPARATOR . $view . '.php';

        if (! file_exists($templateFile)) {
            throw new VewFileNotExists('Given ' . $templateFile . ' file not exists.');
        }

        ob_start();
        extract($params, EXTR_OVERWRITE);

        $this->extend = null;

        require $templateFile;

        /** @var string */
        $content = ob_get_clean();

        if (! $this->extend) {
            return $content;
        }

        return $this->render($this->extend);
    }

    public function extend(string $view): void
    {
        $this->extend = $view;
    }

    public function blockBegin(string $blockName): void
    {
        $this->blockNames->push($blockName);
        ob_start();
    }

    public function blockEnd(): void
    {
        $bufferContent = (string) ob_get_clean();
        $blockName = (string) $this->blockNames->pop();

        if ($this->blockExists($blockName)) {
            return;
        }

        $this->blocks[$blockName] = $bufferContent;
    }

    public function blockRender(string $name): string
    {
        if (is_string($this->blocks[$name])) {
            return $this->blocks[$name] ?? '';
        }

        return $this->blockCallbackRender($name);
    }

    public function blockCallbackRender(string $name): string
    {
        $blockCallback = $this->blocks[$name];

        if ($blockCallback instanceof \Closure) {
            return $blockCallback();
        }

        return '';
    }

    public function blockEnsure(string $blockName): bool
    {
        if ($this->blockExists($blockName)) {
            return false;
        }

        $this->blockBegin($blockName);

        return true;
    }

    public function encode(string $notSafeContent): string
    {
        return htmlspecialchars($notSafeContent, ENT_QUOTES | ENT_SUBSTITUTE);
    }

    private function blockExists(string $name): bool
    {
        return array_key_exists($name, $this->blocks);
    }

    public function path(string $pathName, array $params = []): string
    {
        return (string) $this->router->generate($pathName, $params);
    }
}
