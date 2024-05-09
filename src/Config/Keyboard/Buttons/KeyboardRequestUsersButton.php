<?php

namespace Kolirt\Telegram\Config\Keyboard\Buttons;

use Kolirt\Telegram\Core\Types\Keyboard\Buttons\KeyboardButtonType;

class KeyboardRequestUsersButton extends BaseKeyboardButton
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
        // TODO: Implement request_users
        // request_users:
        );
    }
}
