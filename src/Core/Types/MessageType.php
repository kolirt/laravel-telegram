<?php

namespace Kolirt\Telegram\Core\Types;

/**
 * @see https://core.telegram.org/bots/api#message
 */
class MessageType extends BaseType
{

    public function __construct(
        public int               $message_id,
        public int               $date,
        public ChatType          $chat,
        public int|null          $message_thread_id = null,
        public UserType|null     $from = null,
        public ChatType|null     $sender_chat = null,
        public int|null          $sender_boost_count = null,
        public UserType|null     $sender_business_bot = null,
        public string|null       $business_connection_id = null,
        // public MessageOriginType|null                 $forward_origin = null,
        public bool|null         $is_topic_message = null,
        public bool|null         $is_automatic_forward = null,
        public MessageType|null  $reply_to_message = null,
        // public ExternalReplyInfoType|null             $external_reply = null,
        // public TextQuoteType|null                     $quote = null,
        // public StoryType|null                         $reply_to_story = null,
        public UserType|null     $via_bot = null,
        public int|null          $edit_date = null,
        public bool|null         $has_protected_content = null,
        public bool|null         $is_from_offline = null,
        public string|null       $media_group_id = null,
        public string|null       $author_signature = null,
        public string|null       $text = null,
        // public MessageEntityType[]|null            $entities = null,
        // public LinkPreviewOptionsType|null            $link_preview_options = null,
        // public AnimationType|null                     $animation = null,
        // public AudioType|null                         $audio = null,
        // public DocumentType|null                      $document = null,
        // public PhotoSizeType[]|null                $photo = null,
        // public StickerType|null                       $sticker = null,
        // public StoryType|null                         $story = null,
        // public VideoType|null                         $video = null,
        // public VideoNoteType|null                     $video_note = null,
        // public VoiceType|null                         $voice = null,
        public string|null       $caption = null,
        // public MessageEntityType|null                 $caption_entities = null,
        public bool|null         $has_media_spoiler = null,
        public ContactType|null  $contact = null,
        // public DiceType|null                          $dice = null,
        // public GameType|null                          $game = null,
        // public PollType|null                          $poll = null,
        // public VenueType|null                         $venue = null,
        public LocationType|null $location = null,
        // public UserType[]|null                     $new_chat_members = null,
        public UserType|null     $left_chat_member = null,
        public string|null       $new_chat_title = null,
        // public PhotoSizeType[]|null                $new_chat_photo = null,
        public bool|null         $delete_chat_photo = null,
        public bool|null         $group_chat_created = null,
        public bool|null         $supergroup_chat_created = null,
        public bool|null         $channel_chat_created = null,
        // public MessageAutoDeleteTimerChangedType|null $message_auto_delete_timer_changed = null,
        public int|null          $migrate_to_chat_id = null,
        public int|null          $migrate_from_chat_id = null,
        // public MaybeInaccessibleMessageType|null      $pinned_message = null,
        // public InvoiceType|null                       $invoice = null,
        // public SuccessfulPaymentType|null             $successful_payment = null,
        // public UsersSharedType|null                   $users_shared = null,
        // public ChatSharedType|null                    $chat_shared = null,
        public string|null       $connected_website = null,
        // public WriteAccessAllowedType|null            $write_access_allowed = null,
        // public PassportDataType|null                  $passport_data = null,
        // public ProximityAlertTriggeredType|null       $proximity_alert_triggered = null,
        // public ChatBoostAddedType|null                $boost_added = null,
        // public ForumTopicCreatedType|null             $forum_topic_created = null,
        // public ForumTopicEditedType|null              $forum_topic_edited = null,
        // public ForumTopicClosedType|null              $forum_topic_closed = null,
        // public ForumTopicReopenedType|null            $forum_topic_reopened = null,
        // public GeneralForumTopicHiddenType|null       $general_forum_topic_hidden = null,
        // public GeneralForumTopicUnhiddenType|null     $general_forum_topic_unhidden = null,
        // public GiveawayCreatedType|null               $giveaway_created = null,
        // public GiveawayType|null                      $giveaway = null,
        // public GiveawayWinnersType|null               $giveaway_winners = null,
        // public GiveawayCompletedType|null             $giveaway_completed = null,
        // public VideoChatScheduledType|null            $video_chat_scheduled = null,
        // public VideoChatStartedType|null              $video_chat_started = null,
        // public VideoChatEndedType|null                $video_chat_ended = null,
        // public VideoChatParticipantsInvitedType|null  $video_chat_participants_invited = null,
        // public WebAppDataType|null                    $web_app_data = null,
        // public InlineKeyboardMarkupType|null          $reply_markup = null
    )
    {
    }

    static function from(array $data): self
    {
        return new self(
            message_id: $data['message_id'],
            date: $data['date'],
            chat: ChatType::from($data['chat']),
            message_thread_id: $data['message_thread_id'] ?? null,
            from: response_params(UserType::class, $data['from'] ?? null),
            sender_chat: response_params(ChatType::class, $data['sender_chat'] ?? null),
            sender_boost_count: $data['sender_boost_count'] ?? null,
            sender_business_bot: response_params(UserType::class, $data['sender_business_bot'] ?? null),
            business_connection_id: $data['business_connection_id'] ?? null,
            // forward_origin: $data['forward_origin'] ?? null,
            is_topic_message: $data['is_topic_message'] ?? null,
            is_automatic_forward: $data['is_automatic_forward'] ?? null,
            reply_to_message: response_params(MessageType::class, $data['reply_to_message'] ?? null),
            // external_reply: $data['external_reply'] ?? null,
            // quote: $data['quote'] ?? null,
            // reply_to_story: $data['reply_to_story'] ?? null,
            via_bot: response_params(UserType::class, $data['via_bot'] ?? null),
            edit_date: $data['edit_date'] ?? null,
            has_protected_content: $data['has_protected_content'] ?? null,
            is_from_offline: $data['is_from_offline'] ?? null,
            media_group_id: $data['media_group_id'] ?? null,
            author_signature: $data['author_signature'] ?? null,
            text: $data['text'] ?? null,
            // entities: $data['entities'] ?? null,
            // link_preview_options: $data['link_preview_options'] ?? null,
            // animation: $data['animation'] ?? null,
            // audio: $data['audio'] ?? null,
            // document: $data['document'] ?? null,
            // photo: $data['photo'] ?? null,
            // sticker: $data['sticker'] ?? null,
            // story: $data['story'] ?? null,
            // video: $data['video'] ?? null,
            // video_note: $data['video_note'] ?? null,
            // voice: $data['voice'] ?? null,
            caption: $data['caption'] ?? null,
            // caption_entities: $data['caption_entities'] ?? null,
            has_media_spoiler: $data['has_media_spoiler'] ?? null,
            contact: response_params(ContactType::class, $data['contact'] ?? null),
            // dice: $data['dice'] ?? null,
            // game: $data['game'] ?? null,
            // poll: $data['poll'] ?? null,
            // venue: $data['venue'] ?? null,
            location: response_params(LocationType::class, $data['location'] ?? null),
            // new_chat_members: $data['new_chat_members'] ?? null,
            left_chat_member: response_params(UserType::class, $data['left_chat_member'] ?? null),
            new_chat_title: $data['new_chat_title'] ?? null,
            // new_chat_photo: $data['new_chat_photo'] ?? null,
            delete_chat_photo: $data['delete_chat_photo'] ?? null,
            group_chat_created: $data['group_chat_created'] ?? null,
            supergroup_chat_created: $data['supergroup_chat_created'] ?? null,
            channel_chat_created: $data['channel_chat_created'] ?? null,
            // message_auto_delete_timer_changed: $data['message_auto_delete_timer_changed'] ?? null,
            migrate_to_chat_id: $data['migrate_to_chat_id'] ?? null,
            migrate_from_chat_id: $data['migrate_from_chat_id'] ?? null,
            // pinned_message: $data['pinned_message'] ?? null,
            // invoice: $data['invoice'] ?? null,
            // successful_payment: $data['successful_payment'] ?? null,
            // users_shared: $data['users_shared'] ?? null,
            // chat_shared: $data['chat_shared'] ?? null,
            connected_website: $data['connected_website'] ?? null,
        // write_access_allowed: $data['write_access_allowed'] ?? null,
        // passport_data: $data['passport_data'] ?? null,
        // proximity_alert_triggered: $data['proximity_alert_triggered'] ?? null,
        // boost_added: $data['boost_added'] ?? null,
        // forum_topic_created: $data['forum_topic_created'] ?? null,
        // forum_topic_edited: $data['forum_topic_edited'] ?? null,
        // forum_topic_closed: $data['forum_topic_closed'] ?? null,
        // forum_topic_reopened: $data['forum_topic_reopened'] ?? null,
        // general_forum_topic_hidden: $data['general_forum_topic_hidden'] ?? null,
        // general_forum_topic_unhidden: $data['general_forum_topic_unhidden'] ?? null,
        // giveaway_created: $data['giveaway_created'] ?? null,
        // giveaway: $data['giveaway'] ?? null,
        // giveaway_winners: $data['giveaway_winners'] ?? null,
        // giveaway_completed: $data['giveaway_completed'] ?? null,
        // video_chat_scheduled: $data['video_chat_scheduled'] ?? null,
        // video_chat_started: $data['video_chat_started'] ?? null,
        // video_chat_ended: $data['video_chat_ended'] ?? null,
        // video_chat_participants_invited: $data['video_chat_participants_invited'] ?? null,
        // web_app_data: $data['web_app_data'] ?? null,
        // reply_markup: $data['reply_markup'] ?? null,
        );
    }
}
