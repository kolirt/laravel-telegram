<?php

namespace Kolirt\Telegram\Config\Traits;

use Kolirt\Telegram\Config\Command;
use Kolirt\Telegram\Config\CommandBuilder;

trait CommandBuildable
{

    protected CommandBuilder $command_builder;

    private function isCommand(string|null $text): bool
    {
        return $text && preg_match('/^\//', $text);
    }

    public function commands($fn): self
    {
        $this->command_builder = new CommandBuilder;
        $fn($this->command_builder);
        return $this;
    }

    /**
     * @return Command[]
     */
    public function getCommands(): array
    {
        return $this->command_builder->getCommands();
    }

}
