<?php

namespace Kolirt\Telegram\Core\Types;

abstract class BaseType
{
    abstract static function from(array $data): self;

    public function render(): array
    {
        return (array)$this;
    }
}
