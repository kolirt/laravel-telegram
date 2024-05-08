<?php

namespace Kolirt\Telegram\Config;

use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Core\Types\Updates\UpdateType;
use Kolirt\Telegram\Models\Chat;
use Kolirt\Telegram\Models\User;
use ReflectionMethod;

class Command
{

    public Bot $bot;
    public Telegram $telegram;
    public UpdateType $context;
    public Chat|null $chat;
    public User|null $user;

    public function __construct(
        protected string       $name,
        protected string|array $handler,
        protected string       $description
    )
    {
    }

    public function setBot(Bot $bot): self
    {
        $this->bot = $bot;
        return $this;
    }

    public function setTelegram(Telegram $telegram): self
    {
        $this->telegram = $telegram;
        return $this;
    }

    public function setContext(UpdateType $context): self
    {
        $this->context = $context;
        return $this;
    }

    public function setChat(Chat|null $chat): self
    {
        $this->chat = $chat;
        return $this;
    }

    public function setUser(User|null $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function run(string $args): void
    {
        $class = is_array($this->handler) ? $this->handler[0] : $this->handler;
        $method = is_array($this->handler) ? $this->handler[1] : '__invoke';
        $params = [];

        $handler = new $class(
            $this->bot,
            $this->telegram,
            $this->context,
            $this->chat,
            $this->user
        );

        $ref = new ReflectionMethod($handler, $method);
        $ref_params = $ref->getParameters();
        if (count($ref_params)) {
            $type = $ref->getParameters()[0]->getType();
            if ($type && class_exists($type->getName())) {
                $args = new ($type->getName())($args);
            }
            $params[] = $args;
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

}
