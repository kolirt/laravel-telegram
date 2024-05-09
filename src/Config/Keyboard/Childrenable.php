<?php

namespace Kolirt\Telegram\Config\Keyboard;

trait Childrenable
{

    protected KeyboardBuilder $keyboard;

    public function children($fn): self
    {
        $this->keyboard = new KeyboardBuilder;
        $fn($this->keyboard);
        return $this;
    }

}
