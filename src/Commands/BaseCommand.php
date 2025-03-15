<?php

namespace Kolirt\Telegram\Commands;

use Illuminate\Database\Eloquent\Model;
use Kolirt\Telegram\Config\Bot;
use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Core\Types\Updates\UpdateType;
use Kolirt\Telegram\Models\Chat;
use Kolirt\Telegram\Models\Pivots\BotChatPivot;
use Kolirt\Telegram\Models\User;

class BaseCommand
{

    public function __construct(
        protected Bot                     $bot,
        protected Telegram                $telegram,
        protected UpdateType              $context,
        protected Model|Chat|null         $chat_model = null,
        protected Model|User|null         $user_model = null,
        protected Model|BotChatPivot|null $bot_chat_pivot_model = null,
        protected array                   $args = []
    )
    {
    }

}
