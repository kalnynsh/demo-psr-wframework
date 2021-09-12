<?php

namespace Framework\Template;

class TemplateRenderer implements TemplateRendererInterface
{
    private string $path;
    private ?string $extend;
    private array $blocks = [];
    private \SplStack $blockNames;

    public function __construct(string $path)
    {
        $this->path = $path;
        $this->blockNames = new \SplStack();
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
        $templateFile = $this->path . DIRECTORY_SEPARATOR . $view . '.php';

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

    private function blockExists(string $name): bool
    {
        return array_key_exists($name, $this->blocks);
    }
}
