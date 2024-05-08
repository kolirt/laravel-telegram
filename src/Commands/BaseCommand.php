<?php

namespace Kolirt\Telegram\Commands;

use Kolirt\Telegram\Config\TelegramBotConfig;
use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Core\Types\Updates\UpdateType;
use Kolirt\Telegram\Models\TelegramChat;
use Kolirt\Telegram\Models\TelegramUser;

class BaseCommand
{

    public function __construct(
        protected TelegramBotConfig $bot_config,
        protected Telegram          $telegram,
        protected UpdateType        $context,
        protected TelegramChat|null $chat,
        protected TelegramUser|null $user
    )
    {
    }

}
