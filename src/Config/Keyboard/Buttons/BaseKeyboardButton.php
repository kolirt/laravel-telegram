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

    protected string $name;
    protected string $label;

    protected string $parent_path;

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

    public function setParentPath(string $path): self
    {
        $this->parent_path = $path;
        return $this;
    }

    public function getParentPath(): string
    {
        return $this->parent_path;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

}
