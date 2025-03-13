<?php

namespace Kolirt\Telegram\ConsoleCommands\Bot;

use Illuminate\Console\Command;
use Kolirt\Telegram\Config\Config;
use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Core\Types\Commands\BotCommandType;
use Kolirt\Telegram\Facades\Config as ConfigFacade;

class BotUpdateCommandsConsoleCommand extends Command
{

    protected $signature = 'telegram:bot-update-commands {bot_name}';

    protected $description = 'Update bot commands';

    public function handle(): void
    {
        $bot_name = $this->argument('bot_name');

        $bot_model = config('telegram.models.bot.model')::where('name', $bot_name)->first();
        if ($bot_model) {
            /**
             * @var Config $config
             */
            $config = ConfigFacade::getFacadeRoot();
            $config->load();

            $bot = $config->getBot($bot_model->name);
            if ($bot) {
                $telegram = new Telegram($bot_model->token);

                /**
                 * @var BotCommandType[] $commands
                 */
                $commands = [];

                /** @var \Kolirt\Telegram\Config\Command\Command $command */
                foreach ($bot->getCommandsForUpdate() as $command) {
                    $commands[] = new BotCommandType(
                        command: $command->getCommandName(),
                        description: $command->getDescription()
                    );
                }

                if ($telegram->setMyCommands(commands: $commands)) {
                    $this->info('Commands updated');
                } else {
                    $this->error('Commands not updated');
                }
            } else {
                $this->error('Commands not found');
            }

        } else {
            $this->error('Bot ' . $bot_name . ' not found');
        }
    }
}
