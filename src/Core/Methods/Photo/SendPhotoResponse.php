<?php

namespace Kolirt\Telegram\Core\Methods\Photo;


use Kolirt\Telegram\Core\Responses\BaseResponse;
use Kolirt\Telegram\Core\Types\MessageType;

class SendPhotoResponse extends BaseResponse
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
