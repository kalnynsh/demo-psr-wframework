<?php

namespace Framework\Template;

interface TemplateRendererInterface
{
    public function render(string $view, array $params = []): ?string;
}
