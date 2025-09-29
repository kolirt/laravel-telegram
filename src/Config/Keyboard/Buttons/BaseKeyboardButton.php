<?php

namespace Kolirt\Telegram\Config\Keyboard\Buttons;

use Illuminate\Database\Eloquent\Model;
use Kolirt\Telegram\Config\Bot;
use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Core\Types\Keyboard\Buttons\KeyboardButtonType;
use Kolirt\Telegram\Models\Chat;
use Kolirt\Telegram\Models\Pivots\BotChatPivot;
use Kolirt\Telegram\Models\User;
use Kolirt\Telegram\Request\Request;

abstract class BaseKeyboardButton
{

    protected string $name;
    protected string $label;

    protected string $parent_path;

    abstract public function render(): KeyboardButtonType;

    public function run(
        Request                 $request,
        Bot                     $bot,
        Telegram                $telegram,
        Model|Chat|null         $chat,
        Model|User|null         $user,
        Model|BotChatPivot|null $personal_chat,
        bool                    $fallback = false
    )
    {
    }

    public function getParentPath(): string
    {
        return $this->parent_path;
    }

    public function setParentPath(string $path): self
    {
        $this->parent_path = $path;
        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

}
