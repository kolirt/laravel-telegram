<?php

namespace Kolirt\Telegram\Config\Keyboard\Buttons;

use Kolirt\Telegram\Config\Bot;
use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Core\Types\Keyboard\Buttons\KeyboardButtonType;
use Kolirt\Telegram\Core\Types\Updates\UpdateType;
use Kolirt\Telegram\Models\Chat;
use Kolirt\Telegram\Models\Pivots\BotChatPivot;
use Kolirt\Telegram\Models\User;

class KeyboardRequestContactButton extends BaseKeyboardButton
{

    public function __construct(
        protected string $label
    )
    {
    }

    public function render(): KeyboardButtonType
    {
        return new KeyboardButtonType(
            text: $this->getLabel(),
            request_contact: true
        );
    }

    public function run(Bot $bot, Telegram $telegram, UpdateType $context, Chat $chat_model, User $user_model, BotChatPivot $bot_chat_pivot_model, string $input)
    {
        // TODO: Implement run() method.
    }
}
