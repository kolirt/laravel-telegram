<?php

namespace Kolirt\Telegram\Config\Keyboard\Buttons;

use Kolirt\Telegram\Config\Keyboard\Childrenable;
use Kolirt\Telegram\Core\Types\Keyboard\Buttons\KeyboardButtonType;

class KeyboardTextButton extends BaseKeyboardButton
{

    use Childrenable;

    public function __construct(
        protected string       $name,
        protected string|array $handler,
        protected string       $label
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function render(): KeyboardButtonType
    {
        return new KeyboardButtonType(
            text: $this->getLabel()
        );
    }
}
