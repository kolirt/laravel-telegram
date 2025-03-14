<?php

namespace Kolirt\Telegram\Core\Types\Keyboard;

class ReplyKeyboardRemoveType extends BaseReplyMarkupType
{

    public bool $remove_keyboard = true;

    public function __construct(
        bool|null $selective = null
    )
    {
    }

    static function from(array $data): self
    {
        // TODO: Implement from() method.
    }

    public function render(): array
    {
        return (array)$this;
    }

}
