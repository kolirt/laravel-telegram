<?php

namespace Kolirt\Telegram\Core\Methods\Chat;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Kolirt\Telegram\Core\Types\Chat\Member\ChatMemberAdministratorType;
use Kolirt\Telegram\Core\Types\Chat\Member\ChatMemberBannedType;
use Kolirt\Telegram\Core\Types\Chat\Member\ChatMemberLeftType;
use Kolirt\Telegram\Core\Types\Chat\Member\ChatMemberMemberType;
use Kolirt\Telegram\Core\Types\Chat\Member\ChatMemberOwnerType;
use Kolirt\Telegram\Core\Types\Chat\Member\ChatMemberRestrictedType;
use Kolirt\Telegram\Core\Types\Chat\Member\ChatMemberType;

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
     * @return ChatMemberOwnerType|ChatMemberAdministratorType|ChatMemberMemberType|ChatMemberRestrictedType|ChatMemberLeftType|ChatMemberBannedType|null
     *
     * @throws ConnectionException
     * @throws GuzzleException
     */
    public function getChatMember(string|int $chat_id, int $user_id): ChatMemberOwnerType|ChatMemberAdministratorType|ChatMemberMemberType|ChatMemberRestrictedType|ChatMemberLeftType|ChatMemberBannedType|null
    {
        /**
         * @var PendingRequest $this ->client
         */
        $response = $this->client->get('getChatMember', request_params([
            'chat_id' => $chat_id,
            'user_id' => $user_id
        ]))->getBody();

        $response = json_decode($response, true);

        if ($response['ok']) {
            return ChatMemberType::from($response['result']);
        }

        return null;
    }

}
