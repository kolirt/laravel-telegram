<?php

namespace Kolirt\Telegram\Config\Command\Traits;

use Kolirt\Telegram\Config\Command\CommandBuilder;

trait CommandBuildable
{

    protected CommandBuilder $command_builder;

    public function commands($fn): self
    {
        $this->command_builder = new CommandBuilder;
        $fn($this->command_builder);
        return $this;
    }

    public function getCommandsForUpdate(): array
    {
        return $this->command_builder->getCommandsForUpdate();
    }

}
