<?php

namespace Kolirt\Telegram\Config\Command;

trait CommandBuildable
{

    protected CommandBuilder $command_builder;

    public function commands($fn): self
    {
        $this->command_builder = new CommandBuilder;
        $fn($this->command_builder);
        return $this;
    }

}
