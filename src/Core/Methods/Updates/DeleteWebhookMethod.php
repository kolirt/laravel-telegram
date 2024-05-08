<?php

namespace Kolirt\Telegram\Core\Methods\Updates;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;

/**
 * @see https://core.telegram.org/bots/api#deletewebhook
 */
trait DeleteWebhookMethod
{

    /**
     * Use this method to remove webhook integration if you decide to switch
     * back to getUpdates. Returns True on success.
     *
     * @param bool|null $drop_pending_updates
     *
     * @return bool
     *
     * @throws GuzzleException
     * @throws ConnectionException
     */
    public function deleteWebhook(
        bool|null $drop_pending_updates = null
    ): bool
    {
        /**
         * @var PendingRequest $this ->client
         */
        $response = $this->client->post('deleteWebhook', request_params([
            'drop_pending_updates' => $drop_pending_updates
        ]))->getBody();

        $data = json_decode($response, true);

        return $data['ok'];
    }

}
