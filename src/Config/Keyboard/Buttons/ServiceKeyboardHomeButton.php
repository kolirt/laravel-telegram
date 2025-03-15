<?php

namespace Kolirt\Telegram\Config\Keyboard\Buttons;

use Kolirt\Telegram\Core\Types\Keyboard\Buttons\KeyboardButtonType;

class ServiceKeyboardHomeButton extends BaseKeyboardButton
{
    public function __construct(
        protected string $label
    )
    {
    }

    public function render(): KeyboardButtonType
    {
        return new KeyboardButtonType(
            text: $this->getLabel(),
        // TODO: Implement request_chat
        // request_chat:
        );
    }

}
