<?php

namespace Kolirt\Telegram\Config;

use Kolirt\Telegram\Core\Types\Keyboard\Buttons\KeyboardButtonType;
use function Laravel\Prompts\text;

class VirtualRoute
{

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

    public function renderKeyboardButton(): KeyboardButtonType
    {
        return new KeyboardButtonType(
            text: $this->label
        );
    }

}
