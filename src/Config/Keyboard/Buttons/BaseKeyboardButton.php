<?php

namespace Kolirt\Telegram\Config\Keyboard\Buttons;

use Kolirt\Telegram\Config\Bot;
use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Core\Types\Keyboard\Buttons\KeyboardButtonType;
use Kolirt\Telegram\Core\Types\Updates\UpdateType;
use Kolirt\Telegram\Models\Chat;
use Kolirt\Telegram\Models\Pivots\BotChatPivot;
use Kolirt\Telegram\Models\User;

abstract class BaseKeyboardButton
{

    abstract public function getLabel(): string;

    abstract public function render(): KeyboardButtonType;

    abstract public function run(
        Bot          $bot,
        Telegram     $telegram,
        UpdateType   $context,
        Chat         $chat_model,
        User         $user_model,
        BotChatPivot $bot_chat_pivot_model,
        string       $input
    );

}
