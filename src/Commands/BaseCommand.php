<?php

namespace Kolirt\Telegram\Commands;

use Kolirt\Telegram\Config\Bot;
use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Core\Types\Updates\UpdateType;
use Kolirt\Telegram\Models\Chat;
use Kolirt\Telegram\Models\User;

class BaseCommand
{

    public function __construct(
        protected Bot        $bot,
        protected Telegram   $telegram,
        protected UpdateType $context,
        protected Chat|null  $chat,
        protected User|null  $user
    )
    {
    }

}
