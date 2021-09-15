<?php

namespace Framework\Template\Php;

use Framework\Template\Php\Extension;
use Framework\Template\VewFileNotExists;
use Framework\Http\Router\RouterInterface;
use Framework\Template\TemplateRendererInterface;

class TemplateRenderer implements TemplateRendererInterface
{
    private string $viewPathRoot;
    private ?string $extend;
    private array $blocks = [];

    private \SplStack $blockNames;
    /** @var Extension[] $extensions */
    private array $extensions = [];

    public function __construct(string $viewPathRoot)
    {
        $this->viewPathRoot = $viewPathRoot;
        $this->blockNames = new \SplStack();
    }

    public function addExtension(Extension $extension): void
    {
        $this->extensions[] = $extension;
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
        /** @var int $level */
        $level = ob_get_level();

        /** @var string $templateFile */
        $templateFile = $this->viewPathRoot . DIRECTORY_SEPARATOR . $view . '.php';
        $this->extend = null;

        if (! file_exists($templateFile)) {
            throw new VewFileNotExists('Given ' . $templateFile . ' file not exists.');
        }

        try {
            ob_start();
            extract($params, EXTR_OVERWRITE);
            require $templateFile;

            /** @var string */
            $content = ob_get_clean();
        } catch (\Throwable|\Exception $exc) {
            while (ob_get_level() > $level) {
                ob_end_clean();
            }

            throw $exc;
        }


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

    public function __call($name, $arguments)
    {
        foreach ($this->extensions as $extension) {
            $functions = $extension->getFunctions();

            if (array_key_exists($name, $functions)) {
                return $functions[$name](...$arguments);
            }
        }

        throw new \InvalidArgumentException('Given undifined function "' . $name . '"');
    }
}
