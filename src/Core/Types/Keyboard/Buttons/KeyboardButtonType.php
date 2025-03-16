<?php

namespace Kolirt\Telegram\Core\Types\Keyboard\Buttons;

use Kolirt\Telegram\Core\Types\WebAppInfoType;

class KeyboardButtonType extends BaseButtonType
{
    public function __construct(
        public string              $text,
        // public KeyboardButtonRequestUsersType|null $request_users = null,
        // public KeyboardButtonRequestChatType|null  $request_chat = null,
        public bool|null           $request_contact = null,
        public bool|null           $request_location = null,
        // public KeyboardButtonPollTypeType|null     $request_poll = null,
        public WebAppInfoType|null $web_app = null,
    )
    {
    }

    static function from(array $data): self
    {
        return new self(
            text: $data['text'],
            // request_users: $data['request_users'] ?? null,
            // request_chat: $data['request_chat'] ?? null,
            request_contact: $data['request_contact'] ?? null,
            request_location: $data['request_location'] ?? null,
            // request_poll: $data['request_poll'] ?? null,
            web_app: $data['web_app'] ?? null,
        );
    }
}
