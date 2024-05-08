<?php

namespace Kolirt\Telegram\Commands\Services;

class CommandArgs
{
    public array $value;

    public function __construct(string $args)
    {
        $this->value = $args !== '' ? explode(' ', $args) : [];
    }
}
