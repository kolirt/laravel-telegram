<?php

namespace Kolirt\Telegram\ConsoleCommands\Initial;

use Illuminate\Console\Command;

class PublishConfigConsoleCommand extends Command
{

    protected $signature = 'telegram:publish-config';

    protected $description = 'Publish the config file';

    public function handle(): void
    {
        $this->call('vendor:publish', [
            '--provider' => 'Kolirt\\Telegram\\ServiceProvider',
            '--tag' => 'config'
        ]);
    }
}
