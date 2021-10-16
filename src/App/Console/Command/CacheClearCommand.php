<?php

namespace App\Console\Command;

use App\Service\FileService\FileManager;
use Framework\Console\CommandInterface;
use Framework\Console\Input;
use Framework\Console\Output;

class CacheClearCommand implements CommandInterface
{
    private array $paths;
    private FileManager $files;

    public function __construct(array $paths, FileManager $files)
    {
        $this->paths = $paths;
        $this->files = $files;
    }

    public function execute(Input $input, Output $output): void
    {
        $output->writeln('<comment>Running cache clearing...</comment>');

        /** @var string $alias */
        $alias = $input->getArgument(1);

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
            if ($this->files->exists($path)) {
                $output->writeln('Removing: ' . $path);

                $this->files->delete($path);
            }

            if (! $this->files->exists($path)) {
                $output->writeln('Skipping ' . $path);
            }
        }

        $output->writeln('<info>Done!</info>');
    }
}
