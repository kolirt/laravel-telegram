<?php

namespace Kolirt\Telegram\Config\Keyboard\Builder\Traits;

use Kolirt\Telegram\Config\Keyboard\Buttons\KeyboardRequestChatButton;
use Kolirt\Telegram\Config\Keyboard\Buttons\KeyboardRequestContactButton;
use Kolirt\Telegram\Config\Keyboard\Buttons\KeyboardRequestLocationButton;
use Kolirt\Telegram\Config\Keyboard\Buttons\KeyboardRequestPollButton;
use Kolirt\Telegram\Config\Keyboard\Buttons\KeyboardRequestUsersButton;
use Kolirt\Telegram\Config\Keyboard\Buttons\KeyboardTextButton;
use Kolirt\Telegram\Config\Keyboard\Buttons\KeyboardWebAppButton;
use Kolirt\Telegram\Config\Keyboard\Line\KeyboardLine;

trait Buttonable
{

    public function text(
        string       $name,
        string|array $handler,
        string       $label,
        string|array $fallback_handler = null
    ): KeyboardTextButton
    {
        $this->line(function (KeyboardLine $keyboard_line) use ($name, $handler, $label, $fallback_handler, &$button) {
            $button = $keyboard_line->text(
                name: $name,
                handler: $handler,
                label: $label,
                fallback_handler: $fallback_handler
            );
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

}
