<?php

namespace Kolirt\Telegram\Config\Keyboard\Buttons;

use Kolirt\Telegram\Config\Keyboard\Buttons\Types\WebAppInfoType;
use Kolirt\Telegram\Core\Types\Keyboard\Buttons\KeyboardButtonType;

class KeyboardWebAppButton extends BaseKeyboardButton
{

    protected WebAppInfoType $web_app;

    public function __construct(
        protected string $label,
        string           $url
    )
    {
        $this->web_app = new WebAppInfoType(
            id: $url
        );
    }

    public function render(): KeyboardButtonType
    {
        return new KeyboardButtonType(
            text: $this->getLabel(),
        // TODO: Implement web_app
        // web_app:
        );
    }

}
