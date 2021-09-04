<?php

namespace Framework\Template;

class TemplateRenderer implements TemplateRendererInterface
{
    private string $path;
    private ?string $extend;
    private array $params = [];

    public function __construct(string $path)
    {
        $this->path = $path;
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

        return $this->render($this->extend, [
            'content' => $content,
        ]);
    }
}
