<?php

namespace Kolirt\Telegram\Core\Methods;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;

/**
 * @see https://core.telegram.org/bots/api#getme
 */
trait GetMeMethod
{

    /**
     * A simple method for testing your bot's authentication token.
     * Requires no parameters. Returns basic information about the bot in form of a User object.
     *
     * @return GetMeResponse
     *
     * @throws ConnectionException
     * @throws GuzzleException
     */
    public function getMe(): GetMeResponse
    {
        /**
         * @var PendingRequest $this ->client
         */
        $response = $this->client->get('getMe')->getBody();

        return new GetMeResponse(json_decode($response, true));
    }

}
