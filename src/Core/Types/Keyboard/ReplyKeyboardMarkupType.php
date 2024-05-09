<?php

namespace Kolirt\Telegram\Core\Types\Keyboard;

use Kolirt\Telegram\Core\Types\Keyboard\Buttons\KeyboardButtonType;

class ReplyKeyboardMarkupType extends BaseReplyMarkupType
{

    /**
     * @param KeyboardButtonType[][] $keyboard
     * @param bool|null $is_persistent
     * @param bool|null $resize_keyboard
     * @param bool|null $one_time_keyboard
     * @param string|null $input_field_placeholder
     * @param bool|null $selective
     */
    public function __construct(
        public array       $keyboard,
        public bool|null   $is_persistent = null,
        public bool|null   $resize_keyboard = null,
        public bool|null   $one_time_keyboard = null,
        public string|null $input_field_placeholder = null,
        public bool|null   $selective = null
    )
    {
    }

    static function from(array $data): self
    {
        // TODO: Implement from() method.
    }

    public function render(): array
    {
        $data = (array)$this;

        $data['keyboard'] = array_map(function ($line) {
            return array_map(function ($button) {
                return (array)$button;
            }, $line);
        }, $data['keyboard']);

        return $data;
    }
}