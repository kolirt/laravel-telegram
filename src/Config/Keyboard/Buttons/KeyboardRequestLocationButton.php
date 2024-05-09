<?php

namespace Kolirt\Telegram\Config\Keyboard\Buttons;

use Kolirt\Telegram\Core\Types\Keyboard\Buttons\KeyboardButtonType;

class KeyboardRequestLocationButton extends BaseKeyboardButton
{

    public function __construct(
        protected string $label
    )
    {
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function render(): KeyboardButtonType
    {
        return new KeyboardButtonType(
            text: $this->getLabel(),
            request_location: true
        );
    }
}
