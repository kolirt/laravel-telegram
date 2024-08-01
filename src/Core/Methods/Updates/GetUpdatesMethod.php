<?php

namespace Kolirt\Telegram\Core\Methods\Updates;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;

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
     * @return GetUpdatesResponse
     *
     * @throws ConnectionException
     * @throws GuzzleException
     */
    public function getUpdates(
        int|null   $offset = null,
        int|null   $limit = null,
        int|null   $timeout = null,
        array|null $allowed_updates = null,
    ): GetUpdatesResponse
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

        return new GetUpdatesResponse(json_decode($response, true));
    }

}
