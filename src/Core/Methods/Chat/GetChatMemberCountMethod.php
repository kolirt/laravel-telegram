<?php

namespace Kolirt\Telegram\Core\Methods\Chat;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;

/**
 * @see https://core.telegram.org/bots/api#getchatmembercount
 */
trait GetChatMemberCountMethod
{

    /**
     * Use this method to get the number of members in a chat. Returns Int on success.
     *
     * @param string|int $chat_id
     *
     * @return GetChatMemberCountResponse
     *
     * @throws ConnectionException
     * @throws GuzzleException
     */
    public function getChatMemberCount(string|int $chat_id): GetChatMemberCountResponse
    {
        /**
         * @var PendingRequest $this ->client
         */
        $response = $this->client->get('getChatMemberCount', request_params([
            'chat_id' => $chat_id,
        ]))->getBody();

        return new GetChatMemberCountResponse(json_decode($response, true));
    }

}
