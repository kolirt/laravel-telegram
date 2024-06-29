<?php

namespace Kolirt\Telegram\Core\Types\Chat\Member;

use Kolirt\Telegram\Core\Types\BaseType;
use Kolirt\Telegram\Core\Types\UserType;

/**
 * @see https://core.telegram.org/bots/api#chatmember
 */
class ChatMemberOwnerType extends BaseType
{
    public function __construct(
        public string      $status,
        public UserType    $user,
        public bool        $is_anonymous,
        public string|null $custom_title = null
    )
    {
    }

    static function from(array $data): self
    {
        return new self(
            status: $data['status'],
            user: UserType::from($data['user']),
            is_anonymous: $data['is_anonymous'],
            custom_title: $data['custom_title'] ?? null,
        );
    }
}