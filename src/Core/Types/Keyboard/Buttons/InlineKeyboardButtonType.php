<?php

namespace Kolirt\Telegram\Core\Types\Keyboard\Buttons;

use Kolirt\Telegram\Core\Types\WebAppInfoType;

class InlineKeyboardButtonType extends BaseButtonType
{
    public function __construct(
        public string              $text,
        public string|null         $url = null,
        public string|null         $callback_data = null,
        public WebAppInfoType|null $web_app = null,
        // public LoginUrlType|null                    $login_url = null,
        public string|null         $switch_inline_query = null,
        public string|null         $switch_inline_query_current_chat = null,
        // public SwitchInlineQueryChosenChatType|null $switch_inline_query_chosen_chat = null,
        // public CopyTextButtonType|null $copy_text = null,
        // public CallbackGameType|null                $callback_game = null,
        public bool|null           $pay = null,
    )
    {
    }

    static function from(array $data): self
    {
        // TODO: Implement from() method.
        return new self(
            text: $data['text'],
            url: $data['url'] ?? null,
            callback_data: $data['callback_data'] ?? null,
            web_app: $data['web_app'] ?? null,
            // login_url: $data['login_url'] ?? null,
            switch_inline_query: $data['switch_inline_query'] ?? null,
            switch_inline_query_current_chat: $data['switch_inline_query_current_chat'] ?? null,
            // switch_inline_query_chosen_chat: $data['switch_inline_query_chosen_chat'] ?? null,
            // callback_game: $data['callback_game'] ?? null,
            pay: $data['pay'] ?? null,
        );
    }

    public function render(): array
    {
        $data = (array)$this;

        if (!is_null($data['web_app'])) {
            $data['web_app'] = $data['web_app']->render();
        }

        return $data;
    }
}
