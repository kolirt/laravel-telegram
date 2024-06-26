<?php

namespace Kolirt\Telegram\Config\Keyboard\Buttons\Traits;

use Kolirt\Telegram\Config\Keyboard\Builder\KeyboardBuilder;

trait Childrenable
{

    protected KeyboardBuilder $keyboard;

    public function children($fn): void
    {
        $this->keyboard = new KeyboardBuilder(
            lined_back_and_home_buttons: $this->configuration->lined_back_and_home_buttons,
            reverse_back_and_home_buttons: $this->configuration->reverse_back_and_home_buttons,
            back_button_label: $this->configuration->back_button_label,
            home_button_enabled: $this->configuration->home_button_enabled,
            home_button_label: $this->configuration->home_button_label,
        );
        $this->keyboard->addToPath($this->name);
        $fn($this->keyboard);
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
