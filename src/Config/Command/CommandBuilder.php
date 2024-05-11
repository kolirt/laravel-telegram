<?php

namespace Kolirt\Telegram\Config\Command;

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

    public function isStartCommand(string $command_name): bool
    {
        return $command_name === 'start';
    }

    public function isCommand(string|null $text): bool
    {
        return $text && preg_match('/^\//', $text);
    }

    public function empty(): bool
    {
        return empty($this->commands);
    }

}
