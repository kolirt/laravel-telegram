<?php

namespace Kolirt\Telegram\Core\Types\Keyboard;

use Kolirt\Telegram\Core\Types\BaseType;

class ReplyKeyboardRemoveType extends BaseReplyMarkupType
{

    public true $remove_keyboard = true;

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