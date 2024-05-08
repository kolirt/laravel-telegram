<?php

namespace Kolirt\Telegram\ConsoleCommands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateMetaConsoleCommand extends Command
{

    protected $signature = 'telegram:meta';

    protected $description = 'Generate metadata';

    public function handle(): void
    {
        $stub = File::get(__DIR__ . '/../../stubs/.phpstorm.meta.php/telegram.meta.php.stub');

        $bot_names = config('telegram.models.bot.model')::query()->get('name')
            ->pluck('name')
            ->map(fn($bot_name) => "'$bot_name'");
        $stub = str_replace('{{ bot_names }}', $bot_names->implode(",\n        "), $stub);

        if (!File::isDirectory('.phpstorm.meta.php')) {
            File::makeDirectory('.phpstorm.meta.php');
        }

        $metadata_file_exists = telegram_metadata_generated();
        File::put(base_path('.phpstorm.meta.php/' . config('telegram.metadata_filename')), $stub);

        if ($metadata_file_exists) {
            $this->info('Metadata ' . config('telegram.metadata_filename') . ' updated');
        } else {
            $this->info('Metadata ' . config('telegram.metadata_filename') . ' generated');
        }
    }
}
