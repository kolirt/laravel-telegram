<?php

namespace Kolirt\Telegram\Config\Keyboard;

use Kolirt\Telegram\Config\Keyboard\Buttons\KeyboardRequestChatButton;
use Kolirt\Telegram\Config\Keyboard\Buttons\KeyboardRequestContactButton;
use Kolirt\Telegram\Config\Keyboard\Buttons\KeyboardRequestLocationButton;
use Kolirt\Telegram\Config\Keyboard\Buttons\KeyboardRequestPollButton;
use Kolirt\Telegram\Config\Keyboard\Buttons\KeyboardRequestUsersButton;
use Kolirt\Telegram\Config\Keyboard\Buttons\KeyboardTextButton;
use Kolirt\Telegram\Config\Keyboard\Buttons\KeyboardWebAppButton;

class KeyboardLine
{

    /**
     * @var KeyboardTextButton[] | KeyboardRequestUsersButton[] |
     * @var KeyboardRequestChatButton[] | KeyboardRequestContactButton[] |
     * @var KeyboardRequestLocationButton[] | KeyboardRequestPollButton[] |
     * @var KeyboardWebAppButton[]
     */
    protected array $buttons = [];

    public function text(string $name, string|array $handler, string $label): KeyboardTextButton
    {
        $text = new KeyboardTextButton($name, $handler, $label);
        $this->buttons[] = $text;
        return $text;
    }

    public function requestUsers(string $label): KeyboardRequestUsersButton
    {
        $requestUsers = new KeyboardRequestUsersButton($label);
        $this->buttons[] = $requestUsers;
        return $requestUsers;
    }

    public function requestChat(string $label): KeyboardRequestChatButton
    {
        $request_chat = new KeyboardRequestChatButton($label);
        $this->buttons[] = $request_chat;
        return $request_chat;
    }

    public function requestContact(string $label): KeyboardRequestContactButton
    {
        $request_contact = new KeyboardRequestContactButton($label);
        $this->buttons[] = $request_contact;
        return $request_contact;
    }

    public function requestLocation(string $label): KeyboardRequestLocationButton
    {
        $request_location = new KeyboardRequestLocationButton($label);
        $this->buttons[] = $request_location;
        return $request_location;
    }

    public function requestPoll(string $label): KeyboardRequestPollButton
    {
        $request_poll = new KeyboardRequestPollButton($label);
        $this->buttons[] = $request_poll;
        return $request_poll;
    }

    public function webApp(string $label): KeyboardWebAppButton
    {
        $web_app = new KeyboardWebAppButton($label);
        $this->buttons[] = $web_app;
        return $web_app;
    }

    public function render()
    {
        return array_map(fn($button) => $button->render(), $this->buttons);
    }

}