<?php

namespace Kolirt\Telegram\Core\Methods\Commands;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;

/**
 * @see https://core.telegram.org/bots/api#deletemycommands
 */
trait DeleteMyCommandsMethod
{

    /**
     * Use this method to delete the list of the bot's commands for the
     * given scope and user language. After deletion, higher level commands
     * will be shown to affected users. Returns True on success.
     *
     * @param string|null $language_code
     *
     * @return bool
     *
     * @throws ConnectionException
     * @throws GuzzleException
     */
    public function deleteMyCommands(
        // BotCommandScopeType|null $scope = null,
        string|null $language_code = null,
    ): bool
    {
        /**
         * @var PendingRequest $this ->client
         */
        $response = $this->client->post('deleteMyCommands', request_params([
            // 'scope' => $scope,
            'language_code' => $language_code,
        ]))->getBody();

        $data = json_decode($response, true);

        return $data['ok'];
    }

}
