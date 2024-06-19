<?php

namespace Kolirt\Telegram\Core\Types\Keyboard\Buttons;

use Kolirt\Telegram\Core\Types\BaseType;

abstract class BaseButtonType extends BaseType
{

    public function render(): array
    {
        return (array)$this;
    }

}
