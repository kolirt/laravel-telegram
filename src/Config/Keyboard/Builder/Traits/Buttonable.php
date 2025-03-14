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

    public function textButton(
        string       $name,
        string       $label,
        string|array $handler,
        string|array $fallback_handler = null
    ): KeyboardTextButton
    {
        $this->line(function (KeyboardLine $keyboard_line) use ($name, $handler, $label, $fallback_handler, &$button) {
            $button = $keyboard_line->textButton(
                name: $name,
                handler: $handler,
                label: $label,
                fallback_handler: $fallback_handler
            );
        });

        return $button;
    }

    public function requestUsersButton(string $label): KeyboardRequestUsersButton
    {
        $this->line(function (KeyboardLine $keyboard_line) use ($label, &$button) {
            $button = $keyboard_line->requestUsersButton($label);
        });

        return $button;
    }

    public function requestChatButton(string $label): KeyboardRequestChatButton
    {
        $this->line(function (KeyboardLine $keyboard_line) use ($label, &$button) {
            $button = $keyboard_line->requestChatButton($label);
        });

        return $button;
    }

    public function requestContactButton(string $label): KeyboardRequestContactButton
    {
        $this->line(function (KeyboardLine $keyboard_line) use ($label, &$button) {
            $button = $keyboard_line->requestContactButton($label);
        });

        return $button;
    }

    public function requestLocationButton(string $label): KeyboardRequestLocationButton
    {
        $this->line(function (KeyboardLine $keyboard_line) use ($label, &$button) {
            $button = $keyboard_line->requestLocationButton($label);
        });

        return $button;
    }

    public function requestPollButton(string $label): KeyboardRequestPollButton
    {
        $this->line(function (KeyboardLine $keyboard_line) use ($label, &$button) {
            $button = $keyboard_line->requestPollButton($label);
        });

        return $button;
    }

    public function webAppButton(string $label): KeyboardWebAppButton
    {
        $this->line(function (KeyboardLine $keyboard_line) use ($label, &$button) {
            $button = $keyboard_line->webAppButton($label);
        });

        return $button;
    }

}
