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
        array        $handler_args = [],
        string|array $fallback_handler = null,
        array        $fallback_handler_args = []
    ): KeyboardTextButton
    {
        $this->line(function (KeyboardLine $keyboard_line) use ($name, $handler, $handler_args, $label, $fallback_handler, $fallback_handler_args, &$button) {
            $button = $keyboard_line->textButton(
                name: $name,
                label: $label,
                handler: $handler,
                handler_args: $handler_args,
                fallback_handler: $fallback_handler,
                fallback_handler_args: $fallback_handler_args,
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

    public function requestPollButton(string $label, string $url): KeyboardRequestPollButton
    {
        $this->line(function (KeyboardLine $keyboard_line) use ($label, &$button) {
            $button = $keyboard_line->requestPollButton($label);
        });

        return $button;
    }

    public function webAppButton(string $label, string $url): KeyboardWebAppButton
    {
        $this->line(function (KeyboardLine $keyboard_line) use ($label, $url, &$button) {
            $button = $keyboard_line->webAppButton(
                label: $label,
                url: $url
            );
        });

        return $button;
    }

}
