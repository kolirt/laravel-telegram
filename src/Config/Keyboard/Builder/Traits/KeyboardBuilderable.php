<?php

namespace Kolirt\Telegram\Config\Keyboard\Builder\Traits;

use Kolirt\Telegram\Config\Keyboard\Builder\KeyboardBuilder;
use Kolirt\Telegram\Core\Types\Keyboard\ReplyKeyboardMarkupType;
use Kolirt\Telegram\Core\Types\Keyboard\ReplyKeyboardRemoveType;

trait KeyboardBuilderable
{

    protected KeyboardBuilder $keyboard_builder;

    public function keyboard($fn): self
    {
        $this->keyboard_builder = new KeyboardBuilder();
        $fn($this->keyboard_builder);
        return $this;
    }

    public function renderReplyKeyboardMarkup(): ReplyKeyboardRemoveType|ReplyKeyboardMarkupType
    {
        if (isset($this->keyboard_builder)) {
            return $this->keyboard_builder->renderReplyKeyboardMarkup();
        } else {
            return new ReplyKeyboardRemoveType(true);
        }
    }

}
