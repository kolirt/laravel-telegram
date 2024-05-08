<?php

namespace Kolirt\Telegram\Core\Types\Updates;

use Kolirt\Telegram\Core\Types\BaseType;
use Kolirt\Telegram\Core\Types\MessageType;

/**
 * @see https://core.telegram.org/bots/api#update
 */
class UpdateType extends BaseType
{

    public function __construct(
        public int              $update_id,
        public MessageType|null $message = null,
        public MessageType|null $edited_message = null,
        public MessageType|null $channel_post = null,
        public MessageType|null $edited_channel_post = null,
        // public BusinessConnectionType|null          $business_connection = null,
        public MessageType|null $business_message = null,
        public MessageType|null $edited_business_message = null,
        // public BusinessMessagesDeletedType|null     $deleted_business_messages = null,
        // public MessageReactionUpdatedType|null      $message_reaction = null,
        // public MessageReactionCountUpdatedType|null $message_reaction_count = null,
        // public InlineQueryType|null                 $inline_query = null,
        // public ChosenInlineResultType|null          $chosen_inline_result = null,
        // public CallbackQueryType|null               $callback_query = null,
        // public ShippingQueryType|null               $shipping_query = null,
        // public PreCheckoutQueryType|null            $pre_checkout_query = null,
        // public PollType|null                        $poll = null,
        // public PollAnswerType|null                  $poll_answer = null,
        // public ChatMemberUpdatedType|null           $my_chat_member = null,
        // public ChatMemberUpdatedType|null           $chat_member = null,
        // public ChatJoinRequestType|null             $chat_join_request = null,
        // public ChatBoostUpdatedType|null            $chat_boost = null,
        // public ChatBoostRemovedType|null            $removed_chat_boost = null,

    )
    {
    }

    static function from(array $data): self
    {
        return new self(
            update_id: $data['update_id'],
            message: response_params(MessageType::class, $data['message'] ?? null),
            edited_message: response_params(MessageType::class, $data['edited_message'] ?? null),
            channel_post: response_params(MessageType::class, $data['channel_post'] ?? null),
            edited_channel_post: response_params(MessageType::class, $data['edited_channel_post'] ?? null),
            // business_connection: response_params(BusinessConnectionType::class, $data['business_connection'] ?? null),
            business_message: response_params(MessageType::class, $data['business_message'] ?? null),
            edited_business_message: response_params(MessageType::class, $data['edited_business_message'] ?? null),
        // deleted_business_messages: response_params(BusinessMessagesDeletedType::class, $data['deleted_business_messages'] ?? null),
        // message_reaction: response_params(MessageReactionUpdatedType::class, $data['message_reaction'] ?? null),
        // message_reaction_count: response_params(MessageReactionCountUpdatedType::class, $data['message_reaction_count'] ?? null),
        // inline_query: response_params(InlineQueryType::class, $data['inline_query'] ?? null),
        // chosen_inline_result: response_params(ChosenInlineResultType::class, $data['chosen_inline_result'] ?? null),
        // callback_query: response_params(CallbackQueryType::class, $data['callback_query'] ?? null),
        // shipping_query: response_params(ShippingQueryType::class, $data['shipping_query'] ?? null),
        // pre_checkout_query: response_params(PreCheckoutQueryType::class, $data['pre_checkout_query'] ?? null),
        // poll: response_params(PollType::class, $data['poll'] ?? null),
        // poll_answer: response_params(PollAnswerType::class, $data['poll_answer'] ?? null),
        // my_chat_member: response_params(ChatMemberUpdatedType::class, $data['my_chat_member'] ?? null),
        // chat_member: response_params(ChatMemberUpdatedType::class, $data['chat_member'] ?? null),
        // chat_join_request: response_params(ChatJoinRequestType::class, $data['chat_join_request'] ?? null),
        // chat_boost: response_params(ChatBoostUpdatedType::class, $data['chat_boost'] ?? null),
        // removed_chat_boost: response_params(ChatBoostRemovedType::class, $data['removed_chat_boost'] ?? null),
        );
    }
}
