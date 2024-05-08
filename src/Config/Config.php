<?php

namespace Kolirt\Telegram\Config;

class Config
{

    /**
     * @var Bot[] $bots
     */
    private array $bots = [];

    public function bot(string $bot_name): Bot
    {
        return $this->bots[$bot_name] = new Bot($bot_name);
    }

    public function getBot(string $bot_name): Bot|null
    {
        return $this->bots[$bot_name] ?? null;
    }

    public function getBots(): array
    {
        return $this->bots;
    }

    public function load(): void
    {
        $config = $this;
        foreach (config('telegram.routes.files') as $file) {
            require_once $file;
        }
    }

}