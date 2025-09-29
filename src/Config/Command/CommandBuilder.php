<?php

namespace Kolirt\Telegram\Config\Command;

class CommandBuilder
{

    /**
     * @var Command[]
     */
    protected array $commands = [];

    public function start(
        string       $description,
        string|array $handler,
        array        $handler_args = [],
        bool         $should_ignore_on_update = false
    ): self
    {
        return $this->command(
            name: 'start',
            description: $description,
            handler: $handler,
            handler_args: $handler_args,
            should_ignore_on_update: $should_ignore_on_update
        );
    }

    public function command(
        string       $name,
        string       $description,
        string|array $handler,
        array        $handler_args = [],
        bool         $should_ignore_on_update = false
    ): self
    {
        $this->commands[$name] = new Command(
            name: $name,
            description: $description,
            handler: $handler,
            handler_args: $handler_args,
            should_ignore_on_update: $should_ignore_on_update
        );
        return $this;
    }

    public function getCommand(string $name): Command|null
    {
        return $this->commands[$name] ?? null;
    }

    public function getCommandsForUpdate(): array
    {
        return array_filter($this->getCommands(), function ($command) {
            return !$command->shouldIgnoreOnUpdate();
        });
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
