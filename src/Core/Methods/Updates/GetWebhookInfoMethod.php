<?php

namespace Kolirt\Telegram\Core\Methods\Updates;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;

/**
 * @see https://core.telegram.org/bots/api#getwebhookinfo
 */
trait GetWebhookInfoMethod
{

    /**
     * Use this method to get current webhook status. Requires no parameters.
     * On success, returns a WebhookInfo object. If the bot is using getUpdates,
     * will return an object with the url field empty.
     *
     * @return GetWebhookInfoResponse
     *
     * @throws ConnectionException
     * @throws GuzzleException
     */
    public function getWebhookInfo(): GetWebhookInfoResponse
    {
        /**
         * @var PendingRequest $this ->client
         */
        $response = $this->client->get('getWebhookInfo')->getBody();

        return new GetWebhookInfoResponse(json_decode($response, true));
    }

}
