<?php

namespace Kolirt\Telegram\Config;

use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Core\Types\Updates\UpdateType;
use Kolirt\Telegram\Models\TelegramChat;
use Kolirt\Telegram\Models\TelegramUser;
use ReflectionMethod;

class CommandConfig
{

    public TelegramBotConfig $bot;
    public Telegram $telegram;
    public UpdateType $context;
    public TelegramChat|null $chat;
    public TelegramUser|null $user;

    public function __construct(
        protected string $command,
        protected array  $handler,
        protected string $description
    )
    {
    }

    public function setBot(TelegramBotConfig $bot): self
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

    public function setChat(TelegramChat|null $chat): self
    {
        $this->chat = $chat;
        return $this;
    }

    public function setUser(TelegramUser|null $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function run(string $args): void
    {
        $handler = new $this->handler[0](
            $this->bot,
            $this->telegram,
            $this->context,
            $this->chat,
            $this->user
        );

        $method = $this->handler[1];
        $params = [];

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

    public function getCommand(): string
    {
        return $this->command;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

}
