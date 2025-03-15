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

    public function textButton(
        string       $name,
        string       $label,
        string|array $handler,
        array        $handler_args = [],
        string|array $fallback_handler = null,
        array        $fallback_handler_args = []
    ): KeyboardTextButton
    {
        $name = $this->path === '' ? $name : $this->path . '.' . $name;

        $text_button = new KeyboardTextButton(
            name: $name,
            label: $label,
            handler: $handler,
            handler_args: $handler_args,
            fallback_handler: $fallback_handler,
            fallback_handler_args: $fallback_handler_args,

            on_top: $this->navigation->on_top,
            lined_back_and_home_buttons: $this->navigation->lined_back_and_home_buttons,
            reverse_back_and_home_buttons: $this->navigation->reverse_back_and_home_buttons,
            back_button_label: $this->navigation->back_button_label,
            home_button_enabled: $this->navigation->home_button_enabled,
            home_button_label: $this->navigation->home_button_label,
        );
        $text_button->setParentPath($this->path);
        $this->buttons[] = $text_button;
        return $text_button;
    }

    public function requestUsersButton(string $label): KeyboardRequestUsersButton
    {
        $request_users_button = new KeyboardRequestUsersButton($label);
        $this->buttons[] = $request_users_button;
        return $request_users_button;
    }

    public function requestChatButton(string $label): KeyboardRequestChatButton
    {
        $request_chat_chat = new KeyboardRequestChatButton($label);
        $this->buttons[] = $request_chat_chat;
        return $request_chat_chat;
    }

    public function requestContactButton(string $label): KeyboardRequestContactButton
    {
        $request_contact_chat = new KeyboardRequestContactButton($label);
        $this->buttons[] = $request_contact_chat;
        return $request_contact_chat;
    }

    public function requestLocationButton(string $label): KeyboardRequestLocationButton
    {
        $request_location_chat = new KeyboardRequestLocationButton($label);
        $this->buttons[] = $request_location_chat;
        return $request_location_chat;
    }

    public function requestPollButton(string $label): KeyboardRequestPollButton
    {
        $request_poll_chat = new KeyboardRequestPollButton($label);
        $this->buttons[] = $request_poll_chat;
        return $request_poll_chat;
    }

    public function webAppButton(string $label): KeyboardWebAppButton
    {
        $web_app_button = new KeyboardWebAppButton($label);
        $this->buttons[] = $web_app_button;
        return $web_app_button;
    }

    /**
     * @return KeyboardTextButton[] | KeyboardRequestUsersButton[] | KeyboardRequestChatButton[] | KeyboardRequestContactButton[] | KeyboardRequestLocationButton[] |KeyboardRequestPollButton[] | KeyboardWebAppButton[]
     */
    public function getButtons(): array
    {
        return $this->buttons;
    }

    /*public function getButtonByLabel(string $label): KeyboardRequestPollButton|KeyboardRequestContactButton|KeyboardRequestChatButton|KeyboardRequestUsersButton|KeyboardRequestLocationButton|KeyboardWebAppButton|KeyboardTextButton|null
    {
        foreach ($this->getButtons() as $button) {
            if ($button->getLabel() == $label) {
                return $button;
            }
        }

        return null;
    }*/

    /*public function getButtonByName(string $name): KeyboardRequestPollButton|KeyboardRequestContactButton|KeyboardRequestChatButton|KeyboardRequestUsersButton|KeyboardRequestLocationButton|KeyboardWebAppButton|KeyboardTextButton|null
    {
        foreach ($this->getButtons() as $button) {
            if ($button->getName() == $name) {
                return $button;
            }
        }

        return null;
    }*/

}
