<?php

namespace Kolirt\Telegram\Config\Keyboard\Buttons;

use Kolirt\Telegram\Core\Types\Keyboard\Buttons\KeyboardButtonType;

abstract class BaseKeyboardButton
{

    abstract public function getLabel(): string;

    abstract public function render(): KeyboardButtonType;

}
