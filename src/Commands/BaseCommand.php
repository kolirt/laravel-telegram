<?php

namespace Kolirt\Telegram\Commands;

use Kolirt\Telegram\Config\Bot;
use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Core\Types\Updates\UpdateType;
use Kolirt\Telegram\Models\Chat;
use Kolirt\Telegram\Models\Pivots\BotChatPivot;
use Kolirt\Telegram\Models\User;
use Kolirt\Telegram\Request\Request;

abstract class BaseCommand
{
    public function __construct(
        protected Request           $request,
        protected Bot               $bot,
        protected Telegram          $telegram,
        protected UpdateType        $context,
        protected Chat|null         $chat = null,
        protected User|null         $user = null,
        protected BotChatPivot|null $personal_chat = null,
        protected array             $args = []
    )
    {
    }
}
