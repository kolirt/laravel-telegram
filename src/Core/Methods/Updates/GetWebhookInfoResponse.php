<?php

namespace Kolirt\Telegram\Core\Methods\Updates;

use Kolirt\Telegram\Core\Responses\BaseResponse;
use Kolirt\Telegram\Core\Types\Updates\WebhookInfoType;

class GetWebhookInfoResponse extends BaseResponse
{

    public WebhookInfoType $result;

    public function __construct(array $response)
    {
        parent::__construct($response);

        if (isset($response['result'])) {
            $this->result = WebhookInfoType::from($response['result']);
        }
    }

}
