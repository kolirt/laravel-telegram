<?php

namespace Kolirt\Telegram\Config\Keyboard\Line\Traits;

use Kolirt\Telegram\Config\Keyboard\Buttons\KeyboardRequestChatButton;
use Kolirt\Telegram\Config\Keyboard\Buttons\KeyboardRequestContactButton;
use Kolirt\Telegram\Config\Keyboard\Buttons\KeyboardRequestLocationButton;
use Kolirt\Telegram\Config\Keyboard\Buttons\KeyboardRequestPollButton;
use Kolirt\Telegram\Config\Keyboard\Buttons\KeyboardRequestUsersButton;
use Kolirt\Telegram\Config\Keyboard\Buttons\KeyboardTextButton;
use Kolirt\Telegram\Config\Keyboard\Buttons\KeyboardWebAppButton;

trait Buttonable
{

    /**
     * @var KeyboardTextButton[] | KeyboardRequestUsersButton[] |
     * @var KeyboardRequestChatButton[] | KeyboardRequestContactButton[] |
     * @var KeyboardRequestLocationButton[] | KeyboardRequestPollButton[] |
     * @var KeyboardWebAppButton[]
     */
    protected array $buttons = [];

    public function text(
        string       $name,
        string|array $handler,
        string       $label,
        string|array $fallback_handler = null
    ): KeyboardTextButton
    {
        $name = $this->path === '' ? $name : $this->path . '.' . $name;

        $text = new KeyboardTextButton(
            name: $name,
            handler: $handler,
            label: $label,
            fallback_handler: $fallback_handler,

            lined_back_and_home_buttons: $this->configuration->lined_back_and_home_buttons,
            reverse_back_and_home_buttons: $this->configuration->reverse_back_and_home_buttons,
            back_button_label: $this->configuration->back_button_label,
            home_button_enabled: $this->configuration->home_button_enabled,
            home_button_label: $this->configuration->home_button_label,
        );
        $text->setParentPath($this->path);
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

    /**
     * @return KeyboardTextButton[] | KeyboardRequestUsersButton[] | KeyboardRequestChatButton[] | KeyboardRequestContactButton[] | KeyboardRequestLocationButton[] |KeyboardRequestPollButton[] | KeyboardWebAppButton[]
     */
    public function getButtons(): array
    {
        return $this->buttons;
    }

    public function getButtonByLabel(string $label): KeyboardRequestPollButton|KeyboardRequestContactButton|KeyboardRequestChatButton|KeyboardRequestUsersButton|KeyboardRequestLocationButton|KeyboardWebAppButton|KeyboardTextButton|null
    {
        foreach ($this->getButtons() as $button) {
            if ($button->getLabel() == $label) {
                return $button;
            }
        }

        return null;
    }

    public function getButtonByName(string $name): KeyboardRequestPollButton|KeyboardRequestContactButton|KeyboardRequestChatButton|KeyboardRequestUsersButton|KeyboardRequestLocationButton|KeyboardWebAppButton|KeyboardTextButton|null
    {
        foreach ($this->getButtons() as $button) {
            if ($button->getName() == $name) {
                return $button;
            }
        }

        return null;
    }

}
