<?php

namespace Kolirt\Telegram\Config\Command;

class CommandBuilder
{

    /**
     * @var Command[]
     */
    protected array $commands = [];

    public function start(string|array $handler, string $description, bool $should_ignore_on_update = false): self
    {
        return $this->command('start', $handler, $description, $should_ignore_on_update);
    }

    public function command(string $name, string|array $handler, string $description, bool $should_ignore_on_update = false): self
    {
        $this->commands[$name] = new Command($name, $handler, $description, $should_ignore_on_update);
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

    public function getCommandsForUpdate(): array
    {
        return array_filter($this->getCommands(), function ($command) {
            return !$command->shouldIgnoreOnUpdate();
        });
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
