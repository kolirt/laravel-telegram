<?php

namespace Kolirt\Telegram\Config\Traits;

use Kolirt\Telegram\Config\CommandConfig;

trait Commandable
{

    protected array $commands = [];

    private function isCommand(string|null $text)
    {
        return $text && preg_match('/^\//', $text);
    }

    public function command(string $command, array $handler, string $description = ''): self
    {
        $this->commands[$command] = new CommandConfig($command, [$handler[0], $handler[1]], $description);
        return $this;
    }

    public function commands(array $commands): self
    {
        foreach ($commands as $command => $data) {
            $this->command($command, [$data[0], $data[1]], $data[2] ?? '');
        }
        return $this;
    }

    protected function getCommand(string $command): CommandConfig|null
    {
        return $this->commands[$command] ?? null;
    }

    public function getCommands(): array
    {
        return $this->commands;
    }

}
