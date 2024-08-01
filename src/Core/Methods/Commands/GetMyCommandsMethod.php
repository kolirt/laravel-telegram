<?php

namespace Kolirt\Telegram\Core\Methods\Commands;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;

/**
 * @see https://core.telegram.org/bots/api#getmycommands
 */
trait GetMyCommandsMethod
{

    /**
     * Use this method to get the current list of the bot's commands for the
     * given scope and user language. Returns an Array of BotCommand objects.
     * If commands aren't set, an empty list is returned.
     *
     * @param string|null $language_code
     *
     * @return GetMyCommandsResponse
     *
     * @throws ConnectionException
     * @throws GuzzleException
     */
    public function getMyCommands(
        // BotCommandScopeType|null $scope = null,
        string|null $language_code = null,
    ): GetMyCommandsResponse
    {
        /**
         * @var PendingRequest $this ->client
         */
        $response = $this->client->get('getMyCommands', request_params([
            // 'scope' => $scope,
            'language_code' => $language_code,
        ]))->getBody();

        return new GetMyCommandsResponse(json_decode($response, true));
    }

}
