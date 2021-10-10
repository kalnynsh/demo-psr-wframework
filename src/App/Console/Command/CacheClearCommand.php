<?php

namespace App\Console\Command;

use Framework\Console\Input;
use Framework\Console\Output;

class CacheClearCommand
{
    // private string $twigCachePath = 'var/cache/twig';
    private array $paths = [
        'twig' => 'var/cache/twig',
        'db'   => 'var/cache/db',
    ];

    public function execute(Input $input, Output $output): void
    {
        $output->writeln('Running cache clearing...');

        /** @var string $alias */
        $alias = $input->getArgument(0);

        if (empty($alias)) {
            $options = array_merge(['all'], array_keys($this->paths));
            $alias = $input->choose('Choose path', $options);
        }

        if ($alias === 'all') {
            $paths = $this->paths;
        }

        if ($alias !== 'all' && ! array_key_exists($alias, $this->paths)) {
            throw new \InvalidArgumentException('Unknown path alias "' . $alias . '"');
        }

        if ($alias !== 'all' && array_key_exists($alias, $this->paths)) {
            $paths = [$alias => $this->paths[$alias]];
        }

        /** @var string $path */
        foreach ($paths as $path) {
            if (file_exists($path)) {
                $output->writeln('Removing: ' . $path);

                $this->delete($path);
            }

            if (! file_exists($path)) {
                $output->writeln('Skipping ' . $path);
            }
        }

        $output->writeln('Done!');
    }

    private function delete(string $path): void
    {
        if (! file_exists($path)) {
            throw new \RuntimeException('Given undefined path: ' . $path);
        }

        if (is_dir($path)) {
            foreach (scandir($path, SCANDIR_SORT_ASCENDING) as $item) {
                if ($item === '.' || $item === '..') {
                    continue;
                }

                $this->delete($path . DIRECTORY_SEPARATOR . $item);
            }

            if (! rmdir($path)) {
                throw new \RuntimeException('Unable to delete directory ' . $path);
            }
        }

        if (! is_dir($path)) {
            if (! unlink($path)) {
                throw new \RuntimeException('Unable to delete file ' . $path);
            }
        }
    }
}
