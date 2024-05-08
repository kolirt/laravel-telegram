<?php

namespace Kolirt\Telegram\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \Kolirt\Telegram\Config\Config
 */
class Config extends Facade
{

    protected static function getFacadeAccessor(): string
    {
        return 'telegram-config';
    }

}
