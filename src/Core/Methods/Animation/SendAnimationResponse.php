<?php

namespace Kolirt\Telegram\Core\Methods\Animation;


use Kolirt\Telegram\Core\Responses\BaseResponse;
use Kolirt\Telegram\Core\Types\MessageType;

class SendAnimationResponse extends BaseResponse
{

    public MessageType $result;

    public function __construct(array $response)
    {
        parent::__construct($response);

        if (isset($response['result'])) {
            $this->result = MessageType::from($response['result']);
        }
    }

}
