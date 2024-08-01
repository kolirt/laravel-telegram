<?php

namespace Kolirt\Telegram\Core\Methods\Chat;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;

/**
 * @see https://core.telegram.org/bots/api#getchatmember
 */
trait GetChatMemberMethod
{

    /**
     * Use this method to get information about a member of a chat. The method is only guaranteed to work for other
     * users if the bot is an administrator in the chat. Returns a ChatMember object on success.
     *
     * @param string|int $chat_id
     * @param int $user_id
     *
     * @return GetChatMemberResponse
     *
     * @throws ConnectionException
     * @throws GuzzleException
     */
    public function getChatMember(string|int $chat_id, int $user_id): GetChatMemberResponse
    {
        /**
         * @var PendingRequest $this ->client
         */
        $response = $this->client->get('getChatMember', request_params([
            'chat_id' => $chat_id,
            'user_id' => $user_id
        ]))->getBody();

        return new GetChatMemberResponse(json_decode($response, true));
    }

}
