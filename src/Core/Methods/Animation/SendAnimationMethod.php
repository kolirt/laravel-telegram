<?php

namespace Kolirt\Telegram\Core\Methods\Animation;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Kolirt\Telegram\Core\Enums\ParseModeEnum;
use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Core\Types\Keyboard\InlineKeyboardMarkupType;
use Kolirt\Telegram\Core\Types\Keyboard\ReplyKeyboardMarkupType;
use Kolirt\Telegram\Core\Types\Keyboard\ReplyKeyboardRemoveType;

/**
 * @see https://core.telegram.org/bots/api#sendanimation
 */
trait SendAnimationMethod
{

    /**
     * Use this method to send animation files (GIF or H.264/MPEG-4 AVC video without sound).
     * On success, the sent Message is returned. Bots can currently send animation files
     * of up to 50 MB in size, this limit may be changed in the future.
     *
     * @param string|int $chat_id
     * @param string $animation
     * @param string|null $business_connection_id
     * @param int|null $message_thread_id
     * @param string|null $caption
     * @param ParseModeEnum|null $parse_mode
     * @param bool|null $show_caption_above_media
     * @param bool|null $has_spoiler
     * @param bool|null $disable_notification
     * @param bool|null $protect_content
     * @param string|null $message_effect_id
     * @param InlineKeyboardMarkupType|ReplyKeyboardMarkupType|ReplyKeyboardRemoveType|null $reply_markup
     *
     * @return SendAnimationResponse
     *
     * @throws ConnectionException
     * @throws GuzzleException
     */
    public function sendAnimation(
        string|int                                                                    $chat_id,
        string                                                                        $animation,
        string                                                                        $business_connection_id = null,
        int                                                                           $message_thread_id = null,
        string                                                                        $caption = null,
        ParseModeEnum|null                                                            $parse_mode = null,
        // $caption_entities = null,
        bool                                                                          $show_caption_above_media = null,
        bool                                                                          $has_spoiler = null,
        bool                                                                          $disable_notification = null,
        bool                                                                          $protect_content = null,
        string                                                                        $message_effect_id = null,
        // $reply_parameters = null,
        InlineKeyboardMarkupType|ReplyKeyboardMarkupType|ReplyKeyboardRemoveType|null $reply_markup = null,
    ): SendAnimationResponse
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
        $response = $this->client->post('sendAnimation', request_params([
            'business_connection_id' => $business_connection_id,
            'chat_id' => $chat_id,
            'message_thread_id' => $message_thread_id,
            'animation' => $animation,
            'caption' => $caption,
            'parse_mode' => $parse_mode,
            // 'caption_entities' => $caption_entities,
            'show_caption_above_media' => $show_caption_above_media,
            'has_spoiler' => $has_spoiler,
            'disable_notification' => $disable_notification,
            'protect_content' => $protect_content,
            'message_effect_id' => $message_effect_id,
            // 'reply_parameters' => $reply_parameters,
            'reply_markup' => $reply_markup_formatted
        ]))->getBody();

        return new SendAnimationResponse(json_decode($response, true));
    }

    /**
     * Use this method to send animation files (GIF or H.264/MPEG-4 AVC video without sound).
     * On success, the sent Message is returned. Bots can currently send animation files
     * of up to 50 MB in size, this limit may be changed in the future.
     *
     * @param string $animation
     * @param string|null $business_connection_id
     * @param int|null $message_thread_id
     * @param string|null $caption
     * @param ParseModeEnum|null $parse_mode
     * @param bool|null $show_caption_above_media
     * @param bool|null $has_spoiler
     * @param bool|null $disable_notification
     * @param bool|null $protect_content
     * @param string|null $message_effect_id
     * @param InlineKeyboardMarkupType|ReplyKeyboardMarkupType|ReplyKeyboardRemoveType|null $reply_markup
     *
     * @return SendAnimationResponse
     *
     * @throws ConnectionException
     * @throws GuzzleException
     */
    public function replyAnimation(
        string                                                                        $animation,
        string                                                                        $business_connection_id = null,
        int                                                                           $message_thread_id = null,
        string                                                                        $caption = null,
        ParseModeEnum|null                                                            $parse_mode = null,
        // $caption_entities = null,
        bool                                                                          $show_caption_above_media = null,
        bool                                                                          $has_spoiler = null,
        bool                                                                          $disable_notification = null,
        bool                                                                          $protect_content = null,
        string                                                                        $message_effect_id = null,
        // $reply_parameters = null,
        InlineKeyboardMarkupType|ReplyKeyboardMarkupType|ReplyKeyboardRemoveType|null $reply_markup = null,
    ): SendAnimationResponse
    {
        /**
         * @var $this Telegram
         */
        return $this->sendAnimation(
            chat_id: $this->getChatId(),
            animation: $animation,
            business_connection_id: $business_connection_id,
            message_thread_id: $message_thread_id,
            caption: $caption,
            parse_mode: $parse_mode,
            show_caption_above_media: $show_caption_above_media,
            has_spoiler: $has_spoiler,
            disable_notification: $disable_notification,
            protect_content: $protect_content,
            message_effect_id: $message_effect_id,
            // reply_parameters: $reply_parameters,
            reply_markup: $reply_markup,
        );
    }

}
