<?php

namespace Kolirt\Telegram\Config\Keyboard\Line;

use Kolirt\Telegram\Config\Keyboard\Line\Traits\Buttonable;
use Kolirt\Telegram\Core\Types\Keyboard\Buttons\KeyboardButtonType;

class KeyboardLine
{

    use Buttonable;

    /**
     * @return KeyboardButtonType[]
     */
    public function render(): array
    {
        return array_map(fn($button) => $button->render(), $this->buttons);
    }

}