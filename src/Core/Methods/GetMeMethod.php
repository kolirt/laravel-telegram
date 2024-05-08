<?php

namespace Kolirt\Telegram\Core\Methods;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Kolirt\Telegram\Core\Types\UserType;

/**
 * @see https://core.telegram.org/bots/api#getme
 */
trait GetMeMethod
{

    /**
     * A simple method for testing your bot's authentication token.
     * Requires no parameters. Returns basic information about the bot in form of a User object.
     *
     * @return UserType
     * @throws ConnectionException
     * @throws GuzzleException
     */
    public function getMe(): UserType
    {
         /**
         * @var PendingRequest $this->client
         */
        $response = $this->client->get('getMe')->getBody();

        return UserType::from(json_decode($response, true)['result']);
    }

}
