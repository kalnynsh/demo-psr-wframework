<?php

namespace Framework\Template;

/**
 * Resolving view path postfix for action class
 * like $actionClassName = App\Http\Action\Home\IndexAction,
 * $actionDir = ~/App/Http/Action/HomeIndexAction
 *
 * result $this->getViewPathPostfix() return 'home/index'
 */
class ViewPathResolver
{
    private string $actionDir;
    private string $actionClassName;

    public function __construct(string $actionDir, string $actionClassName)
    {
        $this->actionDir = $actionDir;
        $this->actionClassName = $actionClassName;
    }

    public function getViewPathPostfix(): string
    {
        $fullClassName = $this->actionClassName;
        $className = $this->getLastWord($fullClassName, '\\');
        
        $viewName = str_replace('Action', '', $className);
        $viewName = mb_strtolower($viewName);

        $dirName = $this->getLastWord($this->actionDir, DIRECTORY_SEPARATOR);
        $dirName = mb_strtolower($dirName);

        return $dirName . DIRECTORY_SEPARATOR . $viewName;
    }

    public function getLastWord(
        string $wordWithSeparators,
        string $separator = '\\'
    ): string {
        if ($namePosition = strrpos($wordWithSeparators, $separator)) {
            return substr($wordWithSeparators, $namePosition + 1);
        }

        return $wordWithSeparators;
    }
}
