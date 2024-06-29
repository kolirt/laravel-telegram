<?php

namespace Kolirt\Telegram\Core\Types\Chat\Member;

use Kolirt\Telegram\Core\Types\BaseType;
use Kolirt\Telegram\Core\Types\UserType;

/**
 * @see https://core.telegram.org/bots/api#chatmember
 */
class ChatMemberAdministratorType extends BaseType
{
    public function __construct(
        public string      $status,
        public UserType    $user,
        public bool        $can_be_edited,
        public bool        $is_anonymous,
        public bool        $can_manage_chat,
        public bool        $can_delete_messages,
        public bool        $can_manage_video_chats,
        public bool        $can_restrict_members,
        public bool        $can_promote_members,
        public bool        $can_change_info,
        public bool        $can_invite_users,
        public bool        $can_post_stories,
        public bool        $can_edit_stories,
        public bool        $can_delete_stories,
        public bool|null   $can_post_messages = null,
        public bool|null   $can_edit_messages = null,
        public bool|null   $can_pin_messages = null,
        public bool|null   $can_manage_topics = null,
        public string|null $custom_title = null
    )
    {
    }

    static function from(array $data): self
    {
        return new self(
            status: $data['status'],
            user: UserType::from($data['user']),
            can_be_edited: $data['can_be_edited'],
            is_anonymous: $data['is_anonymous'],
            can_manage_chat: $data['can_manage_chat'],
            can_delete_messages: $data['can_delete_messages'],
            can_manage_video_chats: $data['can_manage_video_chats'],
            can_restrict_members: $data['can_restrict_members'],
            can_promote_members: $data['can_promote_members'],
            can_change_info: $data['can_change_info'],
            can_invite_users: $data['can_invite_users'],
            can_post_stories: $data['can_post_stories'],
            can_edit_stories: $data['can_edit_stories'],
            can_delete_stories: $data['can_delete_stories'],
            can_post_messages: $data['can_post_messages'] ?? null,
            can_edit_messages: $data['can_edit_messages'] ?? null,
            can_pin_messages: $data['can_pin_messages'] ?? null,
            can_manage_topics: $data['can_manage_topics'] ?? null,
            custom_title: $data['custom_title'] ?? null,
        );
    }
}