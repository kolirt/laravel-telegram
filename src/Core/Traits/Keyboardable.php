<?php

namespace Kolirt\Telegram\Core\Traits;

use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Core\Types\Keyboard\Buttons\KeyboardButtonType;
use Kolirt\Telegram\Core\Types\Keyboard\ReplyKeyboardMarkupType;
use Kolirt\Telegram\Core\Types\Keyboard\ReplyKeyboardRemoveType;

trait Keyboardable
{

    protected ReplyKeyboardMarkupType|ReplyKeyboardRemoveType|null $attached_keyboard = null;

    public function attachReplyKeyboardMarkupObject(ReplyKeyboardMarkupType|ReplyKeyboardRemoveType $keyboard): self
    {
        $this->attached_keyboard = $keyboard;
        return $this;
    }

    /**
     * @param KeyboardButtonType[][] $keyboard
     * @param bool|null $is_persistent
     * @param bool|null $resize_keyboard
     * @param bool|null $one_time_keyboard
     * @param string|null $input_field_placeholder
     * @param bool|null $selective
     *
     * @return Telegram|Keyboardable
     */
    public function attachReplyKeyboardMarkup(
        array       $keyboard,
        bool|null   $is_persistent = null,
        bool|null   $resize_keyboard = null,
        bool|null   $one_time_keyboard = null,
        string|null $input_field_placeholder = null,
        bool|null   $selective = null,
    ): self
    {
        $this->attached_keyboard = new ReplyKeyboardMarkupType(
            keyboard: $keyboard,
            is_persistent: $is_persistent,
            resize_keyboard: $resize_keyboard,
            one_time_keyboard: $one_time_keyboard,
            input_field_placeholder: $input_field_placeholder,
            selective: $selective
        );

        return $this;
    }

}
