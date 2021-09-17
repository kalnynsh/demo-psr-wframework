<?php

namespace Framework\Template\Twig;

use Framework\Template\TemplateRendererInterface;
use Twig\Environment;

class TwigRenderer implements TemplateRendererInterface
{
    private Environment $twig;
    private string $fileExtension;

    public function __construct(Environment $twig, string $fileExtension)
    {
        $this->twig = $twig;
        $this->fileExtension = $fileExtension;
    }

    public function render(string $view, array $params = []): string
    {
        return $this->twig->render($view . $this->fileExtension, $params);
    }
}
