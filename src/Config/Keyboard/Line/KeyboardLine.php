<?php

namespace Kolirt\Telegram\Config\Keyboard\Line;

use Kolirt\Telegram\Config\Keyboard\Builder\Traits\Pathable;
use Kolirt\Telegram\Config\Keyboard\Line\Traits\Buttonable;
use Kolirt\Telegram\Config\Keyboard\Navigation\Traits\Navigationable;
use Kolirt\Telegram\Core\Types\Keyboard\Buttons\KeyboardButtonType;

class KeyboardLine
{

    use Navigationable {
        Navigationable::navigation as private;
        Navigationable::__construct as private __navigation_construct;
    }
    use Buttonable, Pathable;

    public function __construct(
        bool   $on_top = false,
        bool   $lined_back_and_home_buttons = false,
        bool   $reverse_back_and_home_buttons = false,
        string $back_button_label = '🔙 Back',
        bool   $home_button_enabled = false,
        string $home_button_label = '🏘 Home',
    )
    {
        $this->__navigation_construct(
            on_top: $on_top,
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
