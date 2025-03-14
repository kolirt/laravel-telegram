<?php

namespace Kolirt\Telegram\Config\Keyboard\Navigation;

class Navigation
{

    public function __construct(
        public bool   $on_top = false,
        public bool   $lined_back_and_home_buttons = false,
        public bool   $reverse_back_and_home_buttons = false,

        public string $back_button_label = '🔙 Back',

        public bool   $home_button_enabled = false,
        public string $home_button_label = '🏘 Home',
    )
    {
    }

    public function update(
        bool|null   $on_top = null,
        bool|null   $lined_back_and_home_buttons = null,
        bool|null   $reverse_back_and_home_buttons = null,
        string|null $back_button_label = null,
        bool|null   $home_button_enabled = null,
        string|null $home_button_label = null,
    ): self
    {
        if ($on_top !== null) $this->on_top = $on_top;
        if ($lined_back_and_home_buttons !== null) $this->lined_back_and_home_buttons = $lined_back_and_home_buttons;
        if ($reverse_back_and_home_buttons !== null) $this->reverse_back_and_home_buttons = $reverse_back_and_home_buttons;
        if ($back_button_label !== null) $this->back_button_label = $back_button_label;
        if ($home_button_enabled !== null) $this->home_button_enabled = $home_button_enabled;
        if ($home_button_label !== null) $this->home_button_label = $home_button_label;

        return $this;
    }

}
