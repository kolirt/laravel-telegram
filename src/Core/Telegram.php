<?php

namespace Kolirt\Telegram\Core;

use Illuminate\Support\Facades\Http;
use Kolirt\Telegram\Core\Methods\Animation\SendAnimationMethod;
use Kolirt\Telegram\Core\Methods\Chat\GetChatMemberCountMethod;
use Kolirt\Telegram\Core\Methods\Chat\GetChatMemberMethod;
use Kolirt\Telegram\Core\Methods\Commands\DeleteMyCommandsMethod;
use Kolirt\Telegram\Core\Methods\Commands\GetMyCommandsMethod;
use Kolirt\Telegram\Core\Methods\Commands\SetMyCommandsMethod;
use Kolirt\Telegram\Core\Methods\GetMeMethod;
use Kolirt\Telegram\Core\Methods\Messages\SendMessageMethod;
use Kolirt\Telegram\Core\Methods\Photo\SendPhotoMethod;
use Kolirt\Telegram\Core\Methods\Updates\DeleteWebhookMethod;
use Kolirt\Telegram\Core\Methods\Updates\GetUpdatesMethod;
use Kolirt\Telegram\Core\Methods\Updates\GetWebhookInfoMethod;
use Kolirt\Telegram\Core\Methods\Updates\SetWebhookMethod;
use Kolirt\Telegram\Core\Traits\Keyboardable;
use Kolirt\Telegram\Core\Traits\Updatable;

class Telegram
{
    use Keyboardable, Updatable;

    /** Chat methods */
    use GetChatMemberMethod;
    use GetChatMemberCountMethod;

    /** Commands methods */
    use DeleteMyCommandsMethod;
    use GetMyCommandsMethod;
    use SetMyCommandsMethod;

    /** Messages methods */
    use SendMessageMethod;

    /** Photo methods */
    use SendPhotoMethod;

    /** Animation methods */
    use SendAnimationMethod;

    /** Updates methods */
    use GetUpdatesMethod;
    use SetWebhookMethod;
    use DeleteWebhookMethod;
    use GetWebhookInfoMethod;

    use GetMeMethod;


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
