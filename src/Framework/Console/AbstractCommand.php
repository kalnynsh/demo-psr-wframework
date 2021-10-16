<?php

namespace Framework\Console;

use Framework\Console\Input;
use Framework\Console\Output;

abstract class AbstractCommand implements CommandInterface
{
    private string $name;
    private string $description = '';

    public function __construct(string $name = null)
    {
        if ($name) {
            $this->setName($name);
        }

        if (! $name) {
            $this->setName(static::class);
        }

        $this->configure();
    }

    protected function configure(): void
    {
    }

    abstract public function execute(Input $input, Output $output): void;



    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name ?: static::class;
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
