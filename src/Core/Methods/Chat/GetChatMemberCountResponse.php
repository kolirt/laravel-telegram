<?php

namespace Kolirt\Telegram\Core\Methods\Chat;

use Kolirt\Telegram\Core\Responses\BaseResponse;

class GetChatMemberCountResponse extends BaseResponse
{

    public int $result;

    public function __construct(array $response)
    {
        parent::__construct($response);

        if (isset($response['result'])) {
            $this->result = $response['result'];
        }
    }

}
