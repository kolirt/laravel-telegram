<?php

namespace Kolirt\Telegram\Config\Keyboard\Line;

use Kolirt\Telegram\Config\Keyboard\Builder\Traits\Pathable;
use Kolirt\Telegram\Config\Keyboard\Configuration\Traits\Configurable;
use Kolirt\Telegram\Config\Keyboard\Line\Traits\Buttonable;
use Kolirt\Telegram\Core\Types\Keyboard\Buttons\KeyboardButtonType;

class KeyboardLine
{

    use Configurable {
        Configurable::configuration as private;
        Configurable::__construct as private __configurable_construct;
    }
    use Buttonable, Pathable;

    public function __construct(
        bool   $lined_back_and_home_buttons = false,
        bool   $reverse_back_and_home_buttons = false,
        string $back_button_label = '🔙 Back',
        bool   $home_button_enabled = false,
        string $home_button_label = '🏘 Home',
    )
    {
        $this->__configurable_construct(
            lined_back_and_home_buttons: $lined_back_and_home_buttons,
            reverse_back_and_home_buttons: $reverse_back_and_home_buttons,
            back_button_label: $back_button_label,
            home_button_enabled: $home_button_enabled,
            home_button_label: $home_button_label,
        );
    }

    /**
     * @return KeyboardButtonType[]
     */
    public function render(): array
    {
        return array_map(fn($button) => $button->render(), $this->buttons);
    }

}
