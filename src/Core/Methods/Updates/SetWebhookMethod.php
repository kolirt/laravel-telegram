<?php

namespace Kolirt\Telegram\Core\Methods\Updates;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;

/**
 * @see https://core.telegram.org/bots/api#setwebhook
 */
trait SetWebhookMethod
{

    /**
     * Use this method to specify a URL and receive incoming updates
     * via an outgoing webhook. Whenever there is an update for the bot,
     * we will send an HTTPS POST request to the specified URL, containing
     * a JSON-serialized Update. In case of an unsuccessful request, we
     * will give up after a reasonable amount of attempts. Returns True on success.
     *
     * If you'd like to make sure that the webhook was set by you, you can specify
     * secret data in the parameter secret_token. If specified, the request will
     * contain a header “X-Telegram-Bot-Api-Secret-Token” with the secret token as content.
     *
     * @param string $url
     * @param string|null $ip_address
     * @param int|null $max_connections
     * @param array|null $allowed_updates
     * @param bool|null $drop_pending_updates
     * @param string|null $secret_token
     *
     * @return bool
     *
     * @throws ConnectionException
     * @throws GuzzleException
     */
    public function setWebhook(
        string      $url,
        // InputFileType|null $certificate = null,
        string|null $ip_address = null,
        int|null    $max_connections = null,
        array       $allowed_updates = null,
        bool|null   $drop_pending_updates = null,
        string|null $secret_token = null,
    ):bool
    {
        /**
         * @var PendingRequest $this ->client
         */
        $response = $this->client->post('setWebhook', request_params([
            'url' => $url,
            // 'certificate' => $certificate,
            'ip_address' => $ip_address,
            'max_connections' => $max_connections,
            'allowed_updates' => $allowed_updates,
            'drop_pending_updates' => $drop_pending_updates,
            'secret_token' => $secret_token
        ]))->getBody();

        $data = json_decode($response, true);

        return $data['ok'];
    }

}
