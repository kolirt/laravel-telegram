<?php

namespace Kolirt\Telegram\Core\Methods\Messages;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Kolirt\Telegram\Core\Enums\ParseModeEnum;
use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Core\Types\Keyboard\InlineKeyboardMarkupType;
use Kolirt\Telegram\Core\Types\Keyboard\ReplyKeyboardMarkupType;
use Kolirt\Telegram\Core\Types\Keyboard\ReplyKeyboardRemoveType;
use Kolirt\Telegram\Core\Types\LinkPreviewOptionsType;

/**
 * @see https://core.telegram.org/bots/api#sendmessage
 */
trait SendMessageMethod
{

    /**
     * @param string $text
     * @param string|null $business_connection_id
     * @param int|null $message_thread_id
     * @param ParseModeEnum|null $parse_mode
     * @param LinkPreviewOptionsType|null $link_preview_options
     * @param bool|null $disable_notification
     * @param bool|null $protect_content
     * @param bool|null $allow_paid_broadcast
     * @param bool|null $message_effect_id
     * @param InlineKeyboardMarkupType|ReplyKeyboardMarkupType|ReplyKeyboardRemoveType|null $reply_markup
     *
     * @return SendMessageResponse
     *
     * @throws ConnectionException
     * @throws GuzzleException
     */
    public function reply(
        string                                                                        $text,
        string                                                                        $business_connection_id = null,
        int                                                                           $message_thread_id = null,
        ParseModeEnum|null                                                            $parse_mode = null,
        // $entities = null,
        LinkPreviewOptionsType|null                                                   $link_preview_options = null,
        bool                                                                          $disable_notification = null,
        bool                                                                          $protect_content = null,
        bool                                                                          $allow_paid_broadcast = null,
        bool                                                                          $message_effect_id = null,
        // $reply_parameters = null,
        InlineKeyboardMarkupType|ReplyKeyboardMarkupType|ReplyKeyboardRemoveType|null $reply_markup = null,
    ): SendMessageResponse
    {
        /**
         * @var $this Telegram
         */
        return $this->sendMessage(
            chat_id: $this->getChatId(),
            text: $text,
            business_connection_id: $business_connection_id,
            message_thread_id: $message_thread_id,
            parse_mode: $parse_mode,
            // entities: $entities,
            link_preview_options: $link_preview_options,
            disable_notification: $disable_notification,
            protect_content: $protect_content,
            allow_paid_broadcast: $allow_paid_broadcast,
            message_effect_id: $message_effect_id,
            // reply_parameters: $reply_parameters,
            reply_markup: $reply_markup,
        );
    }

    /**
     * Use this method to send text messages. On success, the sent Message is returned.
     *
     * @param string|int $chat_id
     * @param string $text
     * @param string|null $business_connection_id
     * @param int|null $message_thread_id
     * @param ParseModeEnum|null $parse_mode
     * @param LinkPreviewOptionsType|null $link_preview_options
     * @param bool|null $disable_notification
     * @param bool|null $protect_content
     * @param bool|null $allow_paid_broadcast
     * @param string|null $message_effect_id
     * @param InlineKeyboardMarkupType|ReplyKeyboardMarkupType|ReplyKeyboardRemoveType|null $reply_markup
     *
     * @return SendMessageResponse
     *
     * @throws ConnectionException
     * @throws GuzzleException
     */
    public function sendMessage(
        string|int                                                                    $chat_id,
        string                                                                        $text,
        string                                                                        $business_connection_id = null,
        int                                                                           $message_thread_id = null,
        ParseModeEnum|null                                                            $parse_mode = null,
        // $entities = null,
        LinkPreviewOptionsType|null                                                   $link_preview_options = null,
        bool                                                                          $disable_notification = null,
        bool                                                                          $protect_content = null,
        bool                                                                          $allow_paid_broadcast = null,
        string                                                                        $message_effect_id = null,
        // $reply_parameters = null,
        InlineKeyboardMarkupType|ReplyKeyboardMarkupType|ReplyKeyboardRemoveType|null $reply_markup = null,
    ): SendMessageResponse
    {
        $reply_markup_formatted = null;

        if (!$reply_markup) {
            if ($this->attached_keyboard) {
                $reply_markup_formatted = $this->attached_keyboard->render();
            }
        } else {
            $reply_markup_formatted = $reply_markup->render();
        }

        /**
         * @var PendingRequest $this ->client
         */
        $response = $this->client->post('sendMessage', request_params([
            'business_connection_id' => $business_connection_id,
            'chat_id' => $chat_id,
            'message_thread_id' => $message_thread_id,
            'text' => $text,
            'parse_mode' => $parse_mode ?? config('telegram.default_parse_mode'),
            // 'entities' => $entities,
            'link_preview_options' => $link_preview_options?->render(),
            'disable_notification' => $disable_notification,
            'protect_content' => $protect_content,
            'allow_paid_broadcast' => $allow_paid_broadcast,
            'message_effect_id' => $message_effect_id,
            // 'reply_parameters' => $reply_parameters,
            'reply_markup' => $reply_markup_formatted
        ]))->getBody();

        return new SendMessageResponse(json_decode($response, true));
    }

}
