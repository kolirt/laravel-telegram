<?php

namespace Kolirt\Telegram\ConsoleCommands\Bot;

use Illuminate\Console\Command;
use Kolirt\Telegram\Core\Telegram;

class BotDeleteCommandsConsoleCommand extends Command
{

    protected $signature = 'telegram:bot-delete-commands {bot_name}';

    protected $description = 'Delete bot commands';

    public function handle(): void
    {
        $bot_name = $this->argument('bot_name');

        $bot_model = config('telegram.models.bot.model')::where('name', $bot_name)->first();
        if ($bot_model) {
            $telegram = new Telegram($bot_model->token);

            if ($telegram->deleteMyCommands()) {
                $this->info('Commands deleted');
            } else {
                $this->error('Commands not deleted');
            }
        } else {
            $this->error('Bot ' . $bot_name . ' not found');
        }
    }
}
