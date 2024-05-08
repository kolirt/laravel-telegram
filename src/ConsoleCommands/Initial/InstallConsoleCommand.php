<?php

namespace Kolirt\Telegram\ConsoleCommands\Initial;

use Illuminate\Console\Command;

class InstallConsoleCommand extends Command
{

    protected $signature = 'telegram:install';

    protected $description = 'Installation the package';

    public function handle(): void
    {
        $this->call(PublishCommandsConsoleCommand::class);
        $this->call(PublishConfigConsoleCommand::class);
        $this->call(PublishMigrationsConsoleCommand::class);
        $this->call(PublishRoutesConsoleCommand::class);
    }
}
