<?php

namespace Kolirt\Telegram\Core\Methods\Video;

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
trait SendVideoMethod
{

    /**
     * Use this method to send video files, Telegram clients support MPEG4
     * videos (other formats may be sent as Document). On success, the sent Message is returned.
     * Bots can currently send video files of up to 50 MB in size, this limit may be changed in the future.
     *
     * @param string|int $chat_id
     * @param string $video
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
     * @return SendVideoResponse
     *
     * @throws ConnectionException
     * @throws GuzzleException
     */
    public function sendVideo(
        string|int                                                                    $chat_id,
        string                                                                        $video,
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
    ): SendVideoResponse
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
        $response = $this->client->post('sendPhoto', request_params([
            'business_connection_id' => $business_connection_id,
            'chat_id' => $chat_id,
            'message_thread_id' => $message_thread_id,
            'animation' => $video,
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

        return new SendVideoResponse(json_decode($response, true));
    }

    /**
     * Use this method to send video files, Telegram clients support MPEG4
     * videos (other formats may be sent as Document). On success, the sent Message is returned.
     * Bots can currently send video files of up to 50 MB in size, this limit may be changed in the future.
     *
     * @param string $video
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
     * @return SendVideoResponse
     *
     * @throws ConnectionException
     * @throws GuzzleException
     */
    public function replyVideo(
        string                                                                        $video,
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
    ): SendVideoResponse
    {
        /**
         * @var $this Telegram
         */
        return $this->sendVideo(
            chat_id: $this->getChatId(),
            video: $video,
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
