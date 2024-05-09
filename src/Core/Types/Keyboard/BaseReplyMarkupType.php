<?php

namespace Kolirt\Telegram\Core\Types\Keyboard;

use Kolirt\Telegram\Core\Types\BaseType;

abstract class BaseReplyMarkupType extends BaseType
{

    abstract public function render(): array;

}