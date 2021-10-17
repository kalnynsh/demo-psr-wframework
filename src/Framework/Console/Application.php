<?php

namespace Framework\Console;

class Application
{
    /** @var AbstractCommand[] */
    private $commands;

    public function run(Input $input, Output $output): void
    {
        if ($name = $input->getArgument(0)) {
            $command = $this->resolveCommand($name);
            $command->execute($input, $output);
        }

        if (! $input->getArgument(0)) {
            $this->renderHelpInfo($output);
        }
    }

    public function add(AbstractCommand $command): void
    {
        $this->commands[] = $command;
    }

    private function resolveCommand(string $name): AbstractCommand
    {
        foreach ($this->commands as $command) {
            if ($command->getName() === $name) {
                return $command;
            }
        }

        throw new \InvalidArgumentException('Given undefined command ' . $name);
    }

    private function renderHelpInfo(Output $output): void
    {
        $output->writeln('<comment>Available commands</comment>');
        $output->writeln('');

        foreach ($this->commands as $command) {
            $output->writeln('<info>' . $command->getName() . '</info>' . "\t" . $command->getDescription());
        }

        $output->writeln('');
    }
}
