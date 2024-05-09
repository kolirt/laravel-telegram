<?php

namespace Kolirt\Telegram\Core\Types\Keyboard\Buttons;

use Kolirt\Telegram\Core\Types\BaseType;

class KeyboardButtonType extends BaseType
{
    public function __construct(
        public string    $text,
        // public KeyboardButtonRequestUsersType|null $request_users = null,
        // public KeyboardButtonRequestChatType|null  $request_chat = null,
        public bool|null $request_contact = null,
        public bool|null $request_location = null,
        // public KeyboardButtonPollTypeType|null     $request_poll = null,
        // public WebAppInfoType|null                 $web_app = null,
    )
    {
    }

    static function from(array $data): self
    {
        return new self(
            $data['text'],
            // $data['request_users'] ?? null,
            // $data['request_chat'] ?? null,
            $data['request_contact'] ?? null,
            $data['request_location'] ?? null,
        // $data['request_poll'] ?? null,
        // $data['web_app'] ?? null,
        );
    }
}