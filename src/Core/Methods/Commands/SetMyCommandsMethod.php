<?php

namespace Kolirt\Telegram\Core\Methods\Commands;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Kolirt\Telegram\Core\Types\Commands\BotCommandType;

/**
 * @see https://core.telegram.org/bots/api#setmycommands
 */
trait SetMyCommandsMethod
{

    /**
     * Use this method to change the list of the bot's commands.
     * See this manual for more details about bot commands. Returns True on success.
     *
     * @param BotCommandType[] $commands
     * @param string|null $language_code
     *
     * @return bool
     *
     * @throws ConnectionException
     * @throws GuzzleException
     */
    public function setMyCommands(
        array       $commands,
        // BotCommandScopeType|null $scope = null,
        string|null $language_code = null,
    ): bool
    {
        $formatted_commands = [];
        foreach ($commands as $command) {
            $formatted_commands[] = (array)$command;
        }

        /**
         * @var PendingRequest $this ->client
         */
        $response = $this->client->post('setMyCommands', request_params([
            'commands' => $formatted_commands,
            // 'scope' => $scope,
            'language_code' => $language_code,
        ]))->getBody();

        $data = json_decode($response, true);

        return $data['ok'];
    }

}
