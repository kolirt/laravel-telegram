<?php

namespace Kolirt\Telegram\Core\Methods\Document;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Kolirt\Telegram\Core\Enums\ParseModeEnum;
use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Core\Types\Keyboard\InlineKeyboardMarkupType;
use Kolirt\Telegram\Core\Types\Keyboard\ReplyKeyboardMarkupType;
use Kolirt\Telegram\Core\Types\Keyboard\ReplyKeyboardRemoveType;

/**
 * @see https://core.telegram.org/bots/api#senddocument
 */
trait SendDocumentMethod
{

    /**
     * Use this method to send photos. On success, the sent Message is returned.
     *
     * @param string|int $chat_id
     * @param string $document
     * @param string|null $business_connection_id
     * @param int|null $message_thread_id
     * @param string|null $thumbnail
     * @param string|null $caption
     * @param ParseModeEnum|null $parse_mode
     * @param bool|null $disable_content_type_detection
     * @param bool|null $disable_notification
     * @param bool|null $protect_content
     * @param bool|null $allow_paid_broadcast
     * @param string|null $message_effect_id
     * @param InlineKeyboardMarkupType|ReplyKeyboardMarkupType|ReplyKeyboardRemoveType|null $reply_markup
     *
     * @return SendDocumentResponse
     *
     * @throws ConnectionException
     * @throws GuzzleException
     */
    public function sendDocument(
        string|int                                                                    $chat_id,
        string                                                                        $document,
        string                                                                        $business_connection_id = null,
        int                                                                           $message_thread_id = null,
        string                                                                        $thumbnail = null,
        string                                                                        $caption = null,
        ParseModeEnum|null                                                            $parse_mode = null,
        // $caption_entities = null,
        bool                                                                          $disable_content_type_detection = null,
        bool                                                                          $disable_notification = null,
        bool                                                                          $protect_content = null,
        bool                                                                          $allow_paid_broadcast = null,
        string                                                                        $message_effect_id = null,
        // $reply_parameters = null,
        InlineKeyboardMarkupType|ReplyKeyboardMarkupType|ReplyKeyboardRemoveType|null $reply_markup = null,
    ): SendDocumentResponse
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
        $response = $this->client->post('sendDocument', request_params([
            'business_connection_id' => $business_connection_id,
            'chat_id' => $chat_id,
            'message_thread_id' => $message_thread_id,
            'document' => $document,
            'thumbnail' => $thumbnail,
            'caption' => $caption,
            'parse_mode' => $parse_mode ?? config('telegram.default_parse_mode'),
            // 'caption_entities' => $caption_entities,
            'disable_content_type_detection' => $disable_content_type_detection,
            'disable_notification' => $disable_notification,
            'protect_content' => $protect_content,
            'allow_paid_broadcast' => $allow_paid_broadcast,
            'message_effect_id' => $message_effect_id,
            // 'reply_parameters' => $reply_parameters,
            'reply_markup' => $reply_markup_formatted
        ]))->getBody();

        return new SendDocumentResponse(json_decode($response, true));
    }

    /**
     * Use this method to send photos. On success, the sent Message is returned.
     *
     * @param string $document
     * @param string|null $business_connection_id
     * @param int|null $message_thread_id
     * @param string|null $thumbnail
     * @param string|null $caption
     * @param ParseModeEnum|null $parse_mode
     * @param bool|null $disable_content_type_detection
     * @param bool|null $disable_notification
     * @param bool|null $protect_content
     * @param bool|null $allow_paid_broadcast
     * @param string|null $message_effect_id
     * @param InlineKeyboardMarkupType|ReplyKeyboardMarkupType|ReplyKeyboardRemoveType|null $reply_markup
     *
     * @return SendDocumentResponse
     *
     * @throws ConnectionException
     * @throws GuzzleException
     */
    public function replyDocument(
        string                                                                        $document,
        string                                                                        $business_connection_id = null,
        int                                                                           $message_thread_id = null,
        string                                                                        $thumbnail = null,
        string                                                                        $caption = null,
        ParseModeEnum|null                                                            $parse_mode = null,
        // $caption_entities = null,
        bool                                                                          $disable_content_type_detection = null,
        bool                                                                          $disable_notification = null,
        bool                                                                          $protect_content = null,
        bool                                                                          $allow_paid_broadcast = null,
        string                                                                        $message_effect_id = null,
        // $reply_parameters = null,
        InlineKeyboardMarkupType|ReplyKeyboardMarkupType|ReplyKeyboardRemoveType|null $reply_markup = null,
    ): SendDocumentResponse
    {
        /**
         * @var $this Telegram
         */
        return $this->sendDocument(
            chat_id: $this->getChatId(),
            document: $document,
            business_connection_id: $business_connection_id,
            message_thread_id: $message_thread_id,
            thumbnail: $thumbnail,
            caption: $caption,
            parse_mode: $parse_mode,
            // caption_entities: $caption_entities,
            disable_content_type_detection: $disable_content_type_detection,
            disable_notification: $disable_notification,
            protect_content: $protect_content,
            allow_paid_broadcast: $allow_paid_broadcast,
            message_effect_id: $message_effect_id,
            // reply_parameters: $reply_parameters,
            reply_markup: $reply_markup,
        );
    }

}
