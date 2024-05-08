<?php

namespace Kolirt\Telegram\Config;

use Closure;
use Illuminate\Support\Collection;
use Kolirt\Telegram\Core\Types\Updates\UpdateType;

class TelegramConfig
{

    private array $bots = [];

    public function bot(string $bot_name): TelegramBotConfig
    {
        return $this->bots[$bot_name] = new TelegramBotConfig($bot_name);
    }

    public function getBot(string $bot_name): TelegramBotConfig|null
    {
        return $this->bots[$bot_name] ?? null;
    }

    public function getBots(): array
    {
        return $this->bots;
    }

    public function loadRoutes(): void
    {
        $config = $this;
        foreach (config('telegram.routes.files') as $file) {
            require_once $file;
        }
    }

}
