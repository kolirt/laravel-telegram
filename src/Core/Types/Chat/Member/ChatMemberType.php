<?php

namespace Kolirt\Telegram\Core\Types\Chat\Member;

use Kolirt\Telegram\Core\Types\BaseType;

/**
 * @see https://core.telegram.org/bots/api#chatmember
 */
class ChatMemberType extends BaseType
{
    static function from(array $data): ChatMemberOwnerType|ChatMemberAdministratorType|ChatMemberMemberType|ChatMemberRestrictedType|ChatMemberLeftType|ChatMemberBannedType
    {
        return match ($data['status']) {
            'creator' => ChatMemberOwnerType::from($data),
            'administrator' => ChatMemberAdministratorType::from($data),
            'member' => ChatMemberMemberType::from($data),
            'restricted' => ChatMemberRestrictedType::from($data),
            'left' => ChatMemberLeftType::from($data),
            'kicked' => ChatMemberBannedType::from($data),
        };
    }
}
