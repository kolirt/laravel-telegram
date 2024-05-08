<?php

namespace Kolirt\Telegram\ConsoleCommands\Initial;

use Illuminate\Console\Command;

class PublishCommandsConsoleCommand extends Command
{

    protected $signature = 'telegram:publish-commands';

    protected $description = 'Publish example commands';

    public function handle(): void
    {
        $this->call('vendor:publish', [
            '--provider' => 'Kolirt\\Telegram\\ServiceProvider',
            '--tag' => 'commands'
        ]);
    }
}
