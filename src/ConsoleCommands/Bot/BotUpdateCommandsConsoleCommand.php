<?php

namespace Kolirt\Telegram\ConsoleCommands\Bot;

use Illuminate\Console\Command;
use Kolirt\Telegram\Config\CommandConfig;
use Kolirt\Telegram\Config\TelegramConfig;
use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Core\Types\Commands\BotCommandType;
use Kolirt\Telegram\Facades\TelegramConfig as TelegramConfigFacade;

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
             * @var TelegramConfig $config
             */
            $config = TelegramConfigFacade::getFacadeRoot();
            $config->loadRoutes();

            $bot_config = $config->getBot($bot_model->name);
            if ($bot_config) {
                $telegram = new Telegram($bot_model->token);

                $commands = array_map(function ($command) {
                    /**
                     * @var CommandConfig $command
                     */
                    return new BotCommandType(
                        command: $command->getCommand(),
                        description: $command->getDescription()
                    );
                }, $bot_config->getCommands());

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
