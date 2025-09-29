<?php

namespace Kolirt\Telegram\ConsoleCommands;

use Illuminate\Console\Command;
use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Facades\Config;

class ServeConsoleCommand extends Command
{

    protected $signature = 'telegram:serve {bot_name}';

    protected $description = 'Serve the bot without webhook';

    public function handle(): void
    {
        $bot_name = $this->argument('bot_name');

        if (
            $bot_model = config('telegram.models.bot.model')::where('name', $bot_name)->first()
        ) {
            $bot = Config::getBot($bot_model->name);
            $bot->setModel($bot_model);

            $telegram = new Telegram($bot_model->token);
            $last_update_id = null;

            while (true) {
                $updates = $telegram->getUpdates(
                    offset: -1,
                    limit: 1
                );

                if ($updates->ok && count($updates->result)) {
                    $update = $updates->result[0];

                    if ($update->update_id !== $last_update_id) {
                        $last_update_id = $update->update_id;

                        $telegram->setUpdate($update);
                        $bot->run($telegram);
                    }
                }

                sleep(2);
            }
        } else {
            $this->error('Bot ' . $bot_name . ' not found');
        }
    }
}
