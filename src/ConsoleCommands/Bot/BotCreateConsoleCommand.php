<?php

namespace Kolirt\Telegram\ConsoleCommands\Bot;

use Illuminate\Console\Command;
use Kolirt\Telegram\ConsoleCommands\GenerateMetaConsoleCommand;

class BotCreateConsoleCommand extends Command
{

    protected $signature = 'telegram:bot-create {bot_name} {token}';

    protected $description = 'Create a new bot';

    public function handle(): void
    {
        $bot_name = $this->argument('bot_name');
        $token = $this->argument('token');

        if (!config('telegram.models.bot.model')::where('name', $bot_name)->exists()) {
            config('telegram.models.bot.model')::create([
                'name' => $bot_name,
                'token' => $token
            ]);

            $this->info('Bot ' . $bot_name . ' created');

            if (telegram_metadata_generated()) {
                $this->line('');
                $this->call(GenerateMetaConsoleCommand::class);
            }
        } else {
            $this->error('Bot ' . $bot_name . ' already exists');
        }
    }
}
