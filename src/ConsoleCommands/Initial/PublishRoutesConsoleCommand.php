<?php

namespace Kolirt\Telegram\ConsoleCommands\Initial;

use Illuminate\Console\Command;

class PublishRoutesConsoleCommand extends Command
{

    protected $signature = 'telegram:publish-routes';

    protected $description = 'Publish the route file';

    public function handle(): void
    {
        $this->call('vendor:publish', [
            '--provider' => 'Kolirt\\Telegram\\ServiceProvider',
            '--tag' => 'routes'
        ]);
    }
}
