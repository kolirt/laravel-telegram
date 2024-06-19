<?php

namespace Kolirt\Telegram\Core\Types\Keyboard;

use Kolirt\Telegram\Core\Types\Keyboard\Buttons\InlineKeyboardButtonType;

class InlineKeyboardMarkupType extends BaseReplyMarkupType
{

    /**
     * @param InlineKeyboardButtonType[][] $inline_keyboard
     */
    public function __construct(
        public array $inline_keyboard
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

        $data['inline_keyboard'] = array_map(function ($line) {
            return array_map(function ($button) {
                return $button->render();
            }, $line);
        }, $data['inline_keyboard']);

        return $data;
    }
}
