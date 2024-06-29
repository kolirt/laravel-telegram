<?php

namespace Kolirt\Telegram\Core\Types\Chat\Member;

use Kolirt\Telegram\Core\Types\BaseType;
use Kolirt\Telegram\Core\Types\UserType;

/**
 * @see https://core.telegram.org/bots/api#chatmember
 */
class ChatMemberMemberType extends BaseType
{
    public function __construct(
        public string   $status,
        public UserType $user
    )
    {
    }

    static function from(array $data): self
    {
        return new self(
            status: $data['status'],
            user: UserType::from($data['user'])
        );
    }
}
