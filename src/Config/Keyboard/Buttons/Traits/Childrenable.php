<?php

namespace Kolirt\Telegram\Config\Keyboard\Buttons\Traits;

use Kolirt\Telegram\Config\Keyboard\Builder\KeyboardBuilder;

trait Childrenable
{

    protected KeyboardBuilder $keyboard;

    public function children($fn): self
    {
        $this->keyboard = new KeyboardBuilder;
        $fn($this->keyboard);
        return $this;
    }

    public function getKeyboard(): KeyboardBuilder
    {
        return $this->keyboard;
    }

    public function hasChildren(): bool
    {
        return !empty($this->keyboard) && !$this->keyboard->empty();
    }

}
