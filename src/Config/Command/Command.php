<?php

namespace Kolirt\Telegram\Config\Command;

use Illuminate\Database\Eloquent\Model;
use Kolirt\Telegram\Config\Bot;
use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Models\Chat;
use Kolirt\Telegram\Models\Pivots\BotChatPivot;
use Kolirt\Telegram\Models\User;
use ReflectionMethod;

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

        $params = [];

        $handler = new $class(
            bot: $bot,
            telegram: $telegram,
            context: $telegram->update,
            chat_model: $chat_model,
            user_model: $user_model,
            bot_chat_pivot_model: $bot_chat_pivot_model,
            args: $this->handler_args
        );

        $ref = new ReflectionMethod($handler, $method);
        $ref_params = $ref->getParameters();
        if (count($ref_params)) {
            $type = $ref->getParameters()[0]->getType();
            if ($type && class_exists($type->getName())) {
                $input = new ($type->getName())($input);
            }
            $params[] = $input;
        }

        call_user_func([$handler, $method], ...$params);
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
