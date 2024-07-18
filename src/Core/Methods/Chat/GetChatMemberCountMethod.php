<?php

namespace Kolirt\Telegram\Core\Methods\Chat;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;

/**
 * @see https://core.telegram.org/bots/api#getchatmember
 */
trait GetChatMemberCountMethod
{

    /**
     * Use this method to get the number of members in a chat. Returns Int on success.
     *
     * @param string|int $chat_id
     * @return int|null
     *
     * @throws GuzzleException
     * @throws ConnectionException
     */
    public function getChatMemberCount(string|int $chat_id): int|null
    {
        /**
         * @var PendingRequest $this ->client
         */
        $response = $this->client->get('getChatMemberCount', request_params([
            'chat_id' => $chat_id,
        ]))->getBody();

        $response = json_decode($response, true);

        if ($response['ok']) {
            return $response['result'];
        }

        return null;
    }

}
