<?php

namespace Kolirt\Telegram\Config\Command;

use Illuminate\Database\Eloquent\Model;
use Kolirt\Telegram\Config\Bot;
use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Helpers\Run;
use Kolirt\Telegram\Models\Chat;
use Kolirt\Telegram\Models\Pivots\BotChatPivot;
use Kolirt\Telegram\Models\User;
use Kolirt\Telegram\Request\Request;

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
        Model|Chat|null         $chat,
        Model|User|null         $user,
        Model|BotChatPivot|null $personal_chat,
        string                  $input
    ): void
    {
        $class = is_array($this->handler) ? $this->handler[0] : $this->handler;
        $method = is_array($this->handler) ? $this->handler[1] : '__invoke';

        $request = new Request(
            input: $input,
        );

        $handler = new $class(
            request: $request,
            bot: $bot,
            telegram: $telegram,
            context: $telegram->update,
            chat: $chat,
            user: $user,
            personal_chat: $personal_chat,
            args: $this->handler_args
        );

        (new Run)->call($handler, $method);
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
