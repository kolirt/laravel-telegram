<?php

namespace Kolirt\Telegram\Config\Keyboard;

use Kolirt\Telegram\Config\Keyboard\Buttons\KeyboardRequestChatButton;
use Kolirt\Telegram\Config\Keyboard\Buttons\KeyboardRequestContactButton;
use Kolirt\Telegram\Config\Keyboard\Buttons\KeyboardRequestLocationButton;
use Kolirt\Telegram\Config\Keyboard\Buttons\KeyboardRequestPollButton;
use Kolirt\Telegram\Config\Keyboard\Buttons\KeyboardRequestUsersButton;
use Kolirt\Telegram\Config\Keyboard\Buttons\KeyboardTextButton;
use Kolirt\Telegram\Config\Keyboard\Buttons\KeyboardWebAppButton;
use Kolirt\Telegram\Core\Types\Keyboard\ReplyKeyboardMarkupType;
use Kolirt\Telegram\Core\Types\Keyboard\ReplyKeyboardRemoveType;

class KeyboardBuilder
{

    /** @var KeyboardLine[] */
    protected array $lines = [];

    protected string|array $default_handler;

    public function line($fn): self
    {
        $line = new KeyboardLine();
        $this->lines[] = $line;
        $fn($line);
        return $this;
    }

    public function defaultHandler(string|array $default_handler): self
    {
        $this->default_handler = $default_handler;
        return $this;
    }

    public function text(string $name, string|array $handler, string $label): KeyboardTextButton
    {
        $this->line(function (KeyboardLine $keyboard_line) use ($name, $handler, $label, &$button) {
            $button = $keyboard_line->text($name, $handler, $label);
        });

        return $button;
    }

    public function requestUsers(string $label): KeyboardRequestUsersButton
    {
        $this->line(function (KeyboardLine $keyboard_line) use ($label, &$button) {
            $keyboard_line->requestUsers($label);
        });

        return $button;
    }

    public function requestChat(string $label): KeyboardRequestChatButton
    {
        $this->line(function (KeyboardLine $keyboard_line) use ($label, &$button) {
            $keyboard_line->requestChat($label);
        });

        return $button;
    }

    public function requestContact(string $label): KeyboardRequestContactButton
    {
        $this->line(function (KeyboardLine $keyboard_line) use ($label, &$button) {
            $keyboard_line->requestContact($label);
        });

        return $button;
    }

    public function requestLocation(string $label): KeyboardRequestLocationButton
    {
        $this->line(function (KeyboardLine $keyboard_line) use ($label, &$button) {
            $keyboard_line->requestLocation($label);
        });

        return $button;
    }

    public function requestPoll(string $label): KeyboardRequestPollButton
    {
        $this->line(function (KeyboardLine $keyboard_line) use ($label, &$button) {
            $keyboard_line->requestPoll($label);
        });

        return $button;
    }

    public function webApp(string $label): KeyboardWebAppButton
    {
        $this->line(function (KeyboardLine $keyboard_line) use ($label, &$button) {
            $keyboard_line->webApp($label);
        });

        return $button;
    }

    public function renderReplyKeyboardMarkup(): ReplyKeyboardMarkupType|ReplyKeyboardRemoveType
    {
        if (count($this->lines)) {
            return new ReplyKeyboardMarkupType(
                keyboard: array_map(fn(KeyboardLine $line) => $line->render(), $this->lines)
            );
        } else {
            return new ReplyKeyboardRemoveType(true);
        }
    }

}
