<?php

namespace Kolirt\Telegram\Core\Methods\Updates;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Kolirt\Telegram\Core\Types\Updates\UpdateType;

/**
 * @see https://core.telegram.org/bots/api#getupdates
 */
trait GetUpdatesMethod
{

    /**
     * Use this method to receive incoming updates using long polling (wiki). Returns an Array of Update objects.
     *
     * @param int|null $offset
     * @param int|null $limit
     * @param int|null $timeout
     * @param array|null $allowed_updates
     *
     * @return UpdateType[]|null
     *
     * @throws ConnectionException
     * @throws GuzzleException
     */
    public function getUpdates(
        int|null   $offset = null,
        int|null   $limit = null,
        int|null   $timeout = null,
        array|null $allowed_updates = null,
    ): array|null
    {
        /**
         * @var PendingRequest $this ->client
         */
        $response = $this->client->post('getUpdates', request_params([
            'offset' => $offset,
            'limit' => $limit,
            'timeout' => $timeout,
            'allowed_updates' => $allowed_updates
        ]))->getBody();

        $response = json_decode($response, true);

        if ($response['ok']) {
            return array_map(fn($update) => UpdateType::from($update), $response['result']);
        }

        return null;
    }

}
