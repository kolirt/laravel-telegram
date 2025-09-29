<?php

namespace Kolirt\Telegram\Controllers;

use Kolirt\Telegram\Config\Bot;
use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Core\Types\Updates\UpdateType;
use Kolirt\Telegram\Models\Chat;
use Kolirt\Telegram\Models\Pivots\BotChatPivot;
use Kolirt\Telegram\Models\User;
use Kolirt\Telegram\Request\Request;

abstract class BaseController
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

    public function __init()
    {

    }

    public function goHome(): void
    {
        $this->personal_chat->update([
            'virtual_path' => '',
            'virtual_state' => null,
            'virtual_state_data' => null,
        ]);
        $this->bot->goHome($this->telegram);
    }

}
