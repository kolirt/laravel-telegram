<?php

namespace Kolirt\Telegram\Core\Types;

use Kolirt\Telegram\Core\Enums\ChatTypeEnum;

/**
 * @see https://core.telegram.org/bots/api#chat
 */
class ChatType extends BaseType
{

    public function __construct(
        public int          $id,
        public ChatTypeEnum $type,
        public string|null  $title = null,
        public string|null  $username = null,
        public string|null  $first_name = null,
        public string|null  $last_name = null,
        public true|null    $is_forum = null,
        // public ChatPhotoType|null            $photo = null,
        public array|null   $active_usernames = null,
        // public BirthdateType|null            $birthdate = null,
        // public BusinessIntroType|null        $business_intro = null,
        // public BusinessLocationType|null     $business_location = null,
        // public BusinessOpeningHoursType|null $business_opening_hours = null,
        // public ChatType|null                 $personal_chat = null,
        public array|null   $available_reactions = null,
        public int|null     $accent_color_id = null,
        public string|null  $background_custom_emoji_id = null,
        public int|null     $profile_accent_color_id = null,
        public string|null  $profile_background_custom_emoji_id = null,
        public string|null  $emoji_status_custom_emoji_id = null,
        public int|null     $emoji_status_expiration_date = null,
        public string|null  $bio = null,
        public true|null    $has_private_forwards = null,
        public true|null    $has_restricted_voice_and_video_messages = null,
        public true|null    $join_to_send_messages = null,
        public true|null    $join_by_request = null,
        public string|null  $description = null,
        public string|null  $invite_link = null,
        // public MessageType|null              $pinned_message = null,
        // public ChatPermissionsType|null      $permissions = null,
        public int|null     $slow_mode_delay = null,
        public int|null     $unrestrict_boost_count = null,
        public int|null     $message_auto_delete_time = null,
        public true|null    $has_aggressive_anti_spam_enabled = null,
        public true|null    $has_hidden_members = null,
        public true|null    $has_protected_content = null,
        public true|null    $has_visible_history = null,
        public string|null  $sticker_set_name = null,
        public true|null    $can_set_sticker_set = null,
        public string|null  $custom_emoji_sticker_set_name = null,
        public int|null     $linked_chat_id = null,
        // public ChatLocationType|null         $location = null,
    )
    {
    }

    static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            type: ChatTypeEnum::from($data['type']),
            title: $data['title'] ?? null,
            username: $data['username'] ?? null,
            first_name: $data['first_name'] ?? null,
            last_name: $data['last_name'] ?? null,
            is_forum: $data['is_forum'] ?? null,
            // photo: $data['photo'] ?? null,
            active_usernames: $data['active_usernames'] ?? null,
            // birthdate: $data['birthdate'] ?? null,
            // business_intro: $data['business_intro'] ?? null,
            // business_location: $data['business_location'] ?? null,
            // business_opening_hours: $data['business_opening_hours'] ?? null,
            // personal_chat: $data['personal_chat'] ?? null,
            available_reactions: $data['available_reactions'] ?? null,
            accent_color_id: $data['accent_color_id'] ?? null,
            background_custom_emoji_id: $data['background_custom_emoji_id'] ?? null,
            profile_accent_color_id: $data['profile_accent_color_id'] ?? null,
            profile_background_custom_emoji_id: $data['profile_background_custom_emoji_id'] ?? null,
            emoji_status_custom_emoji_id: $data['emoji_status_custom_emoji_id'] ?? null,
            emoji_status_expiration_date: $data['emoji_status_expiration_date'] ?? null,
            bio: $data['bio'] ?? null,
            has_private_forwards: $data['has_private_forwards'] ?? null,
            has_restricted_voice_and_video_messages: $data['has_restricted_voice_and_video_messages'] ?? null,
            join_to_send_messages: $data['join_to_send_messages'] ?? null,
            join_by_request: $data['join_by_request'] ?? null,
            description: $data['description'] ?? null,
            invite_link: $data['invite_link'] ?? null,
            // pinned_message: $data['pinned_message'] ?? null,
            // permissions: $data['permissions'] ?? null,
            slow_mode_delay: $data['slow_mode_delay'] ?? null,
            unrestrict_boost_count: $data['unrestrict_boost_count'] ?? null,
            message_auto_delete_time: $data['message_auto_delete_time'] ?? null,
            has_aggressive_anti_spam_enabled: $data['has_aggressive_anti_spam_enabled'] ?? null,
            has_hidden_members: $data['has_hidden_members'] ?? null,
            has_protected_content: $data['has_protected_content'] ?? null,
            has_visible_history: $data['has_visible_history'] ?? null,
            sticker_set_name: $data['sticker_set_name'] ?? null,
            can_set_sticker_set: $data['can_set_sticker_set'] ?? null,
            custom_emoji_sticker_set_name: $data['custom_emoji_sticker_set_name'] ?? null,
            linked_chat_id: $data['linked_chat_id'] ?? null,
        // location: $data['location'] ?? null,
        );
    }
}
