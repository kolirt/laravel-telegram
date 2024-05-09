<?php

namespace Kolirt\Telegram\Config\Keyboard;

trait KeyboardBuilderable
{

    protected KeyboardBuilder $keyboard_builder;

    public function keyboard($fn): self
    {
        $this->keyboard_builder = new KeyboardBuilder();
        $fn($this->keyboard_builder);
        return $this;
    }

}
