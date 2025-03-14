<?php

namespace Kolirt\Telegram\Core\Types;

/**
 * @see https://core.telegram.org/bots/api#user
 */
class UserType extends BaseType
{

    public function __construct(
        public int         $id,
        public bool        $is_bot,
        public string|null $first_name,
        public string|null $last_name = null,
        public string|null $username = null,
        public string|null $language_code = null,
        public bool|null   $is_premium = null,
        public bool|null   $added_to_attachment_menu = null,
        public bool|null   $can_join_groups = null,
        public bool|null   $can_read_all_group_messages = null,
        public bool|null   $supports_inline_queries = null,
        public bool|null   $can_connect_to_business = null
    )
    {
    }

    static function from(array $data): self
    {
        return new self(
            $data['id'],
            $data['is_bot'],
            $data['first_name'],
            $data['last_name'] ?? null,
            $data['username'] ?? null,
            $data['language_code'] ?? null,
            $data['is_premium'] ?? null,
            $data['added_to_attachment_menu'] ?? null,
            $data['can_join_groups'] ?? null,
            $data['can_read_all_group_messages'] ?? null,
            $data['supports_inline_queries'] ?? null,
            $data['can_connect_to_business'] ?? null
        );
    }
}
