<?php

namespace App\Console\Command;

use Framework\Console\Input;
use Framework\Console\Output;
use Framework\Console\AbstractCommand;
use App\Service\FileService\FileManager;
use Framework\Console\Helper\Question;

class CacheClearCommand extends AbstractCommand
{
    private array $paths;
    private FileManager $files;

    public function __construct(array $paths, FileManager $files)
    {
        $this->paths = $paths;
        $this->files = $files;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('cache:clear')
            ->setDecription('Clear cache');
    }

    public function execute(Input $input, Output $output): void
    {
        $output->writeln('<comment>Running cache clearing...</comment>');

        /** @var string $alias */
        $alias = $input->getArgument(1);

        if (empty($alias)) {
            $options = \array_merge(['all'], \array_keys($this->paths));

            $alias = Question::choose(
                $input,
                $output,
                'Choose path',
                $options
            );
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
