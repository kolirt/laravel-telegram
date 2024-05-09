<?php

namespace Kolirt\Telegram\Core;

use Illuminate\Support\Facades\Http;
use Kolirt\Telegram\Core\Methods\Commands\DeleteMyCommandsMethod;
use Kolirt\Telegram\Core\Methods\Commands\GetMyCommandsMethod;
use Kolirt\Telegram\Core\Methods\Commands\SetMyCommandsMethod;
use Kolirt\Telegram\Core\Methods\GetMeMethod;
use Kolirt\Telegram\Core\Methods\Messages\SendMessageMethod;
use Kolirt\Telegram\Core\Methods\Updates\DeleteWebhookMethod;
use Kolirt\Telegram\Core\Methods\Updates\GetUpdatesMethod;
use Kolirt\Telegram\Core\Methods\Updates\GetWebhookInfoMethod;
use Kolirt\Telegram\Core\Methods\Updates\SetWebhookMethod;
use Kolirt\Telegram\Core\Traits\Keyboardable;
use Kolirt\Telegram\Core\Traits\Updatable;

class Telegram
{
    use Keyboardable, Updatable;

    use DeleteMyCommandsMethod;
    use GetMyCommandsMethod;
    use SetMyCommandsMethod;

    use GetUpdatesMethod;
    use SetWebhookMethod;
    use DeleteWebhookMethod;
    use GetWebhookInfoMethod;

    use GetMeMethod;
    use SendMessageMethod;

    private readonly string $endpoint;

    private \Illuminate\Http\Client\PendingRequest $client;

    public function __construct(private readonly string $token)
    {
        $this->endpoint = config('telegram.api_endpoint');

        $this->client = Http::withOptions([
            'base_uri' => $this->endpoint . $this->token . '/'
        ]);
    }

}
