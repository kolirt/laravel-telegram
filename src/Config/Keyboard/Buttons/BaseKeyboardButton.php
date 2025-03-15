<?php

namespace Kolirt\Telegram\Config\Keyboard\Buttons;

use Illuminate\Database\Eloquent\Model;
use Kolirt\Telegram\Config\Bot;
use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Core\Types\Keyboard\Buttons\KeyboardButtonType;
use Kolirt\Telegram\Models\Chat;
use Kolirt\Telegram\Models\Pivots\BotChatPivot;
use Kolirt\Telegram\Models\User;

abstract class BaseKeyboardButton
{

    protected string $name;
    protected string $label;

    protected string $parent_path;

    abstract public function render(): KeyboardButtonType;

    public function run(
        Bot                     $bot,
        Telegram                $telegram,
        Model|Chat|null         $chat_model,
        Model|User|null         $user_model,
        Model|BotChatPivot|null $bot_chat_pivot_model,
        string                  $input,
        bool                    $fallback = false
    )
    {
    }

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
