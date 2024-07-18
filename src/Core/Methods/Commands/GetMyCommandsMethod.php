<?php

namespace Kolirt\Telegram\Core\Methods\Commands;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Kolirt\Telegram\Core\Types\Commands\BotCommandType;

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
     * @return BotCommandType[]|null
     *
     * @throws ConnectionException
     * @throws GuzzleException
     */
    public function getMyCommands(
        // BotCommandScopeType|null $scope = null,
        string|null $language_code = null,
    ): array|null
    {
        /**
         * @var PendingRequest $this ->client
         */
        $response = $this->client->get('getMyCommands', request_params([
            // 'scope' => $scope,
            'language_code' => $language_code,
        ]))->getBody();

        $response = json_decode($response, true);

        if ($response['ok']) {
            return array_map(fn($item) => BotCommandType::from($item), $response['result']);
        }

        return null;
    }

}
