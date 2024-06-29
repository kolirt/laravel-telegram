<?php

namespace Kolirt\Telegram\Core\Types\Chat\Member;

use Kolirt\Telegram\Core\Types\BaseType;
use Kolirt\Telegram\Core\Types\UserType;

/**
 * @see https://core.telegram.org/bots/api#chatmember
 */
class ChatMemberRestrictedType extends BaseType
{
    public function __construct(
        public string   $status,
        public UserType $user,
        public bool     $is_member,
        public bool     $can_send_messages,
        public bool     $can_send_audios,
        public bool     $can_send_documents,
        public bool     $can_send_photos,
        public bool     $can_send_videos,
        public bool     $can_send_video_notes,
        public bool     $can_send_voice_notes,
        public bool     $can_send_polls,
        public bool     $can_send_other_messages,
        public bool     $can_add_web_page_previews,
        public bool     $can_change_info,
        public bool     $can_invite_users,
        public bool     $can_pin_messages,
        public bool     $can_manage_topics,
        public int      $until_date
    )
    {
    }

    static function from(array $data): self
    {
        return new self(
            status: $data['status'],
            user: UserType::from($data['user']),
            is_member: $data['is_member'],
            can_send_messages: $data['can_send_messages'],
            can_send_audios: $data['can_send_audios'],
            can_send_documents: $data['can_send_documents'],
            can_send_photos: $data['can_send_photos'],
            can_send_videos: $data['can_send_videos'],
            can_send_video_notes: $data['can_send_video_notes'],
            can_send_voice_notes: $data['can_send_voice_notes'],
            can_send_polls: $data['can_send_polls'],
            can_send_other_messages: $data['can_send_other_messages'],
            can_add_web_page_previews: $data['can_add_web_page_previews'],
            can_change_info: $data['can_change_info'],
            can_invite_users: $data['can_invite_users'],
            can_pin_messages: $data['can_pin_messages'],
            can_manage_topics: $data['can_manage_topics'],
            until_date: $data['until_date'],
        );
    }
}