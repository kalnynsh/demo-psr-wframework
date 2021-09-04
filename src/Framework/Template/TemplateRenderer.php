<?php

namespace Framework\Template;

class TemplateRenderer implements TemplateRendererInterface
{
    private string $path;

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
            throw new VewFileNotExists();
        }

        ob_start();
        extract($params, EXTR_OVERWRITE);

        require $templateFile;

        return ob_get_clean();
    }
}
