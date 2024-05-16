<?php

namespace Kolirt\Telegram\Config\Keyboard\Configuration\Traits;

use Kolirt\Telegram\Config\Keyboard\Configuration\Configuration;

trait Configurable
{

    protected Configuration $configuration;
    protected Configuration $fallback_configuration;

    public function __construct(
        bool   $lined_back_and_home_buttons = false,
        bool   $reverse_back_and_home_buttons = false,

        string $back_button_label = '🔙 Back',

        bool   $home_button_enabled = false,
        string $home_button_label = '🏘 Home',
    )
    {
        $this->configuration = new Configuration(
            lined_back_and_home_buttons: $lined_back_and_home_buttons,
            reverse_back_and_home_buttons: $reverse_back_and_home_buttons,

            back_button_label: $back_button_label,

            home_button_enabled: $home_button_enabled,
            home_button_label: $home_button_label,
        );

        $this->fallback_configuration = new Configuration(
            lined_back_and_home_buttons: $lined_back_and_home_buttons,
            reverse_back_and_home_buttons: $reverse_back_and_home_buttons,

            back_button_label: $back_button_label,

            home_button_enabled: $home_button_enabled,
            home_button_label: $home_button_label,

            initial: false
        );
    }

    public function configuration(
        bool|null   $lined_back_and_home_buttons = null,
        bool|null   $reverse_back_and_home_buttons = null,
        string|null $back_button_label = null,
        bool|null   $home_button_enabled = null,
        string|null $home_button_label = null,
    ): self
    {
        $this->configuration->update(
            lined_back_and_home_buttons: $lined_back_and_home_buttons,
            reverse_back_and_home_buttons: $reverse_back_and_home_buttons,
            back_button_label: $back_button_label,
            home_button_enabled: $home_button_enabled,
            home_button_label: $home_button_label,
        );
        return $this;
    }

    public function fallbackConfiguration(
        bool|null   $lined_back_and_home_buttons = null,
        bool|null   $reverse_back_and_home_buttons = null,
        string|null $back_button_label = null,
        bool|null   $home_button_enabled = null,
        string|null $home_button_label = null,
    ): self
    {
        $this->fallback_configuration->update(
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
        return $this->configuration->home_button_label;
    }

    public function getBackButtonLabel(): ?string
    {
        return $this->configuration->back_button_label;
    }

}
