<?php

namespace Framework\Console;

use Framework\Console\Input;
use Framework\Console\Output;

abstract class AbstractCommand implements CommandInterface
{
    private string $name;
    private string $description;

    abstract public function execute(Input $input, Output $output): void;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDecription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
