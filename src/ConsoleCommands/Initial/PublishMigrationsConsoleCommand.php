<?php

namespace Kolirt\Telegram\ConsoleCommands\Initial;

use Illuminate\Console\Command;

class PublishMigrationsConsoleCommand extends Command
{

    protected $signature = 'telegram:publish-migrations';

    protected $description = 'Publish migration files';

    public function handle(): void
    {
        $this->call('vendor:publish', [
            '--provider' => 'Kolirt\\Telegram\\ServiceProvider',
            '--tag' => 'migrations'
        ]);
    }
}
