<?php

namespace Kolirt\Telegram\Config;

class CommandBuilder
{

    /**
     * @var Command[]
     */
    protected array $commands = [];

    public function start(string|array $handler, string $description): self
    {
        return $this->command('start', $handler, $description);
    }

    public function command(string $name, string|array $handler, string $description): self
    {
        $this->commands[$name] = new Command($name, $handler, $description);
        return $this;
    }

    public function getCommand(string $name): Command|null
    {
        return $this->commands[$name] ?? null;
    }

    /**
     * @return Command[]
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

}
