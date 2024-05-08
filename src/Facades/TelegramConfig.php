<?php

namespace Kolirt\Telegram\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \Kolirt\Telegram\Config\TelegramConfig
 */
class TelegramConfig extends Facade
{

    protected static function getFacadeAccessor(): string
    {
        return 'telegram-config';
    }

}
