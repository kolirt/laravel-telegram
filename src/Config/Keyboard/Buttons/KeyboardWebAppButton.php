<?php

namespace Kolirt\Telegram\Config\Keyboard\Buttons;

use Kolirt\Telegram\Core\Types\Keyboard\Buttons\KeyboardButtonType;
use Kolirt\Telegram\Core\Types\WebAppInfoType;

class KeyboardWebAppButton extends BaseKeyboardButton
{

    protected WebAppInfoType $web_app;

    public function __construct(
        protected string $label,
        string           $url
    )
    {
        $this->web_app = WebAppInfoType::from([
            'url' => $url
        ]);
    }

    public function render(): KeyboardButtonType
    {
        return new KeyboardButtonType(
            text: $this->getLabel(),
            web_app: $this->web_app
        );
    }

}
