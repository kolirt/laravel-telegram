<?php

namespace Kolirt\Telegram\ConsoleCommands\Bot;

use Illuminate\Console\Command;
use Kolirt\Telegram\Core\Telegram;

class BotSetWebhookConsoleCommand extends Command
{

    protected $signature = 'telegram:bot-set-webhook {bot_name}';

    protected $description = 'Set webhook for bot';

    public function handle(): void
    {
        $bot_name = $this->argument('bot_name');

        $bot_model = config('telegram.models.bot.model')::where('name', $bot_name)->first();
        if ($bot_model) {
            $telegram = new Telegram($bot_model->token);

            $domain = preg_replace('/\/$/', '', config('telegram.domain'));
            $path = preg_replace('/^\//', '', str_replace('{token}', $bot_model->token, config('telegram.webhook_path')));
            $url = $domain . '/' . $path;

            if ($telegram->setWebhook(url: $url)->ok) {
                $this->info('Webhook has been set');
            } else {
                $this->error('Webhook has not been set');
            }
        } else {
            $this->error('Bot ' . $bot_name . ' not found');
        }
    }
}
