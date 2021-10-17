<?php

namespace App\Console\Command;

use App\Service\FileService\FileManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class CacheClearCommand extends Command
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
            ->setDescription('Cache clear')
            ->addArgument('alias', InputArgument::OPTIONAL, 'The alias of available paths.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<comment>Running cache clearing...</comment>');

        /** @var string $alias */
        $alias = $input->getArgument('alias');

        if (empty($alias)) {
            $helper = $this->getHelper('question');
            $options = \array_merge(['all'], \array_keys($this->paths));
            $question = new ChoiceQuestion('Choose path', $options, 0);

            $alias = $helper->ask($input, $output, $question);
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

        return Command::SUCCESS;
    }
}
