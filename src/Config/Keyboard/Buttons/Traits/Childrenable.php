<?php

namespace Kolirt\Telegram\Config\Keyboard\Buttons\Traits;

use Kolirt\Telegram\Config\Keyboard\Builder\KeyboardBuilder;

trait Childrenable
{

    protected KeyboardBuilder $keyboard_builder;

    public function children($fn): void
    {
        $this->keyboard_builder = new KeyboardBuilder(
            on_top: $this->navigation->on_top,
            lined_back_and_home_buttons: $this->navigation->lined_back_and_home_buttons,
            reverse_back_and_home_buttons: $this->navigation->reverse_back_and_home_buttons,
            back_button_label: $this->navigation->back_button_label,
            home_button_enabled: $this->navigation->home_button_enabled,
            home_button_label: $this->navigation->home_button_label,
        );
        $this->keyboard_builder->addToPath($this->name);
        $fn($this->keyboard_builder);
    }

    public function getKeyboard(): KeyboardBuilder
    {
        return $this->keyboard_builder;
    }

    public function hasChildren(): bool
    {
        return !empty($this->keyboard_builder) && !$this->keyboard_builder->empty();
    }

}
