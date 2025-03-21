<?php

namespace Kolirt\Telegram\Config\Command;

use Illuminate\Database\Eloquent\Model;
use Kolirt\Telegram\Config\Bot;
use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Helpers\Run;
use Kolirt\Telegram\Models\Chat;
use Kolirt\Telegram\Models\Pivots\BotChatPivot;
use Kolirt\Telegram\Models\User;

class Command
{

    public function __construct(
        protected string       $name,
        protected string       $description,
        protected string|array $handler,
        protected array        $handler_args = [],
        protected bool         $should_ignore_on_update = false
    )
    {
    }

    public function run(
        Bot                     $bot,
        Telegram                $telegram,
        Model|Chat|null         $chat_model,
        Model|User|null         $user_model,
        Model|BotChatPivot|null $bot_chat_pivot_model,
        string                  $input
    ): void
    {
        $class = is_array($this->handler) ? $this->handler[0] : $this->handler;
        $method = is_array($this->handler) ? $this->handler[1] : '__invoke';

        $handler = new $class(
            bot: $bot,
            telegram: $telegram,
            context: $telegram->update,
            chat_model: $chat_model,
            user_model: $user_model,
            bot_chat_pivot_model: $bot_chat_pivot_model,
            args: $this->handler_args
        );

        $run = new Run;
        $run->call($handler, $method, $input);
    }

    public function getCommandName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function shouldIgnoreOnUpdate(): bool
    {
        return $this->should_ignore_on_update;
    }

}
