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

    /*protected function getButtonByPath(string $path)
    {
        $explode = explode('/', preg_replace('/^\//', '', $path));

        $button = null;
        foreach ($explode as $key => $value) {
            $button = $this->getButtonByName($value);
            if ($button) {
                break;
            }
        }

        dd($explode, $button);
    }*/

    /*protected function getButtonByName(string $text)
    {
        foreach ($this->getLines() as $line) {
            $button = $line->getButtonByName($text);
            if ($button) {
                return $button;
            }
        }

        return null;
    }*/

}