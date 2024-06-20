<?php

namespace Kolirt\Telegram\Config;

use Illuminate\Support\Facades\Cache;

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
        foreach (config('telegram.config_files') as $file) {
            require $file;
        }
    }

}
