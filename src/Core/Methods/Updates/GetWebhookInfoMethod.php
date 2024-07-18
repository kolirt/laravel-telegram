<?php

namespace Kolirt\Telegram\Core\Methods\Updates;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Kolirt\Telegram\Core\Types\Updates\WebhookInfoType;

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
     * @return WebhookInfoType|null
     *
     * @throws ConnectionException
     * @throws GuzzleException
     */
    public function getWebhookInfo(): WebhookInfoType|null
    {
        /**
         * @var PendingRequest $this ->client
         */
        $response = $this->client->get('getWebhookInfo')->getBody();

        $response = json_decode($response, true);

        if ($response['ok']) {
            return WebhookInfoType::from($response['result']);
        }

        return null;
    }

}
