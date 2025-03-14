<?php

namespace Kolirt\Telegram\Config\Keyboard\Navigation\Traits;

use Kolirt\Telegram\Config\Keyboard\Navigation\Navigation;

trait Navigationable
{

    protected Navigation $navigation;

    public function __construct(
        bool   $on_top = false,
        bool   $lined_back_and_home_buttons = false,
        bool   $reverse_back_and_home_buttons = false,

        string $back_button_label = '🔙 Back',

        bool   $home_button_enabled = false,
        string $home_button_label = '🏘 Home',
    )
    {
        $this->navigation = new Navigation(
            on_top: $on_top,
            lined_back_and_home_buttons: $lined_back_and_home_buttons,
            reverse_back_and_home_buttons: $reverse_back_and_home_buttons,

            back_button_label: $back_button_label,

            home_button_enabled: $home_button_enabled,
            home_button_label: $home_button_label,
        );
    }

    public function navigation(
        bool|null   $on_top = null,
        bool|null   $lined_back_and_home_buttons = null,
        bool|null   $reverse_back_and_home_buttons = null,
        string|null $back_button_label = null,
        bool|null   $home_button_enabled = null,
        string|null $home_button_label = null,
    ): self
    {
        $this->navigation->update(
            on_top: $on_top,
            lined_back_and_home_buttons: $lined_back_and_home_buttons,
            reverse_back_and_home_buttons: $reverse_back_and_home_buttons,
            back_button_label: $back_button_label,
            home_button_enabled: $home_button_enabled,
            home_button_label: $home_button_label,
        );
        return $this;
    }


    public function getHomeButtonLabel(): ?string
    {
        return $this->navigation->home_button_label;
    }

    public function getBackButtonLabel(): ?string
    {
        return $this->navigation->back_button_label;
    }

}
